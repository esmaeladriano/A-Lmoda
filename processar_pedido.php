<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "⚠️ Acesso negado. Faça login para finalizar o pedido.";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Verificar se os campos obrigatórios foram enviados
$campos = ['nome', 'telefone', 'endereco', 'localidade', 'pagamento'];
foreach ($campos as $campo) {
    if (empty($_POST[$campo])) {
        echo "❌ Preencha todos os campos obrigatórios.";
        exit;
    }
}

// Capturar dados do formulário
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$localidade = $_POST['localidade'];
$pagamento = $_POST['pagamento'];
$observacoes = $_POST['observacoes'] ?? "";

// Obter itens do carrinho do usuário
$sql = "SELECT c.id_produto, p.preco, c.quantidade 
        FROM carrinho c
        JOIN produtos p ON c.id_produto = p.id
        WHERE c.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "🛒 Seu carrinho está vazio.";
    exit;
}

// Preparar os itens e calcular total
$itens = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $subtotal = $row['preco'] * $row['quantidade'];
    $total += $subtotal;
    $itens[] = [
        'id_produto' => $row['id_produto'],
        'quantidade' => $row['quantidade'],
        'preco' => $row['preco']
    ];
}

// Inserir pedido
$stmt = $conn->prepare("INSERT INTO pedidos 
    (id_usuario, total, nome_cliente, telefone, endereco, localidade, pagamento, observacoes, data_pedido) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");

$stmt->bind_param("idssssss", 
    $id_usuario, $total, $nome, $telefone, $endereco, $localidade, $pagamento, $observacoes);
$stmt->execute();

$id_pedido = $stmt->insert_id;

// Inserir itens do pedido
$stmt_item = $conn->prepare("INSERT INTO itens_pedido 
    (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");

foreach ($itens as $item) {
    $stmt_item->bind_param("iiid", $id_pedido, $item['id_produto'], $item['quantidade'], $item['preco']);
    $stmt_item->execute();
}

// Limpar o carrinho
$stmt = $conn->prepare("DELETE FROM carrinho WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

// Sucesso
echo "<div style='padding: 20px; font-family: sans-serif'>";
echo "<h2>✅ Pedido efetuado com sucesso!</h2>";
echo "<p>Número do pedido: <b>#{$id_pedido}</b></p>";
echo "<p>Total: <b>KZ " . number_format($total, 2) . "</b></p>";
echo "<a href='index.php' class='btn btn-primary'>Voltar à loja</a>";
echo "</div>";
?>
