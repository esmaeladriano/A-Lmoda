<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "É necessário estar logado para fazer o pedido.";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Obter itens do carrinho
$sql = "SELECT c.id_produto, c.quantidade, p.preco 
        FROM carrinho c 
        JOIN produtos p ON c.id_produto = p.id 
        WHERE c.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Seu carrinho está vazio.";
    exit;
}

$total = 0;
$itens = [];
while ($row = $result->fetch_assoc()) {
    $subtotal = $row['preco'] * $row['quantidade'];
    $total += $subtotal;
    $itens[] = $row;
}

// Inserir o pedido
$stmt = $conn->prepare("INSERT INTO pedidos (id_usuario, total) VALUES (?, ?)");
$stmt->bind_param("id", $id_usuario, $total);
$stmt->execute();
$id_pedido = $stmt->insert_id;

// Inserir os itens do pedido
$stmt_item = $conn->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
foreach ($itens as $item) {
    $stmt_item->bind_param("iiid", $id_pedido, $item['id_produto'], $item['quantidade'], $item['preco']);
    $stmt_item->execute();
}

// Limpar carrinho
$stmt = $conn->prepare("DELETE FROM carrinho WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

echo "✅ Pedido efetuado com sucesso! Pedido nº: $id_pedido";
?>
