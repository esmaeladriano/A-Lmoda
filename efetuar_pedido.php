<?php
// session_start();
// include_once('conexao.php');

// if (!isset($_SESSION['usuario_id'])) {
//     echo "É necessário estar logado para fazer o pedido.";
//     exit;
// }

// $id_usuario = $_SESSION['usuario_id'];

// // Obter itens do carrinho
// $sql = "SELECT c.id_produto, c.quantidade, p.preco 
//         FROM carrinho c 
//         JOIN produtos p ON c.id_produto = p.id 
//         WHERE c.id_usuario = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $id_usuario);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows === 0) {
//     echo "Seu carrinho está vazio.";
//     exit;
// }

// $total = 0;
// $itens = [];
// while ($row = $result->fetch_assoc()) {
//     $subtotal = $row['preco'] * $row['quantidade'];
//     $total += $subtotal;
//     $itens[] = $row;
// }

// // Inserir o pedido
// $stmt = $conn->prepare("INSERT INTO pedidos (id_usuario, total) VALUES (?, ?)");
// $stmt->bind_param("id", $id_usuario, $total);
// $stmt->execute();
// $id_pedido = $stmt->insert_id;

// // Inserir os itens do pedido
// $stmt_item = $conn->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
// foreach ($itens as $item) {
//     $stmt_item->bind_param("iiid", $id_pedido, $item['id_produto'], $item['quantidade'], $item['preco']);
//     $stmt_item->execute();
// }

// // Limpar carrinho
// $stmt = $conn->prepare("DELETE FROM carrinho WHERE id_usuario = ?");
// $stmt->bind_param("i", $id_usuario);
// $stmt->execute();

// echo "✅ Pedido efetuado com sucesso! Pedido nº: $id_pedido";
?>
<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "⚠️ É necessário estar logado para fazer o pedido.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['acao'] === 'fazer_pedido') {

    $id_usuario = $_SESSION['usuario_id'];
    $endereco = trim($_POST['endereco']);
    $forma_pagamento = trim($_POST['pagamento']);

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
        echo "🛒 Seu carrinho está vazio.";
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
    $stmt = $conn->prepare("INSERT INTO pedidos (id_usuario, total, endereco_entrega, forma_pagamento, data_pedido) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("idss", $id_usuario, $total, $endereco, $forma_pagamento);
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

    echo "✅ Pedido nº <b>$id_pedido</b> criado com sucesso!<br>Total: <b>KZ ".number_format($total, 2)."</b><br>Forma de Pagamento: <b>$forma_pagamento</b>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Efetuar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            text-align: center;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1.2rem;
            color: #6c757d;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 1.2rem;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .form-control {
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 1.2rem;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }
        </style>

<!-- Botão para abrir o formulário -->
<button id="btnFazerPedido">🛒 Fazer Pedido</button>

<!-- Formulário escondido inicialmente -->
<div id="formularioPedido" style="display:none; margin-top:20px;">
  <h3>📦 Detalhes do Pedido</h3>
  <form id="pedidoForm">
    <label>Endereço de Entrega:</label><br />
    <textarea name="endereco" required></textarea><br /><br />
    
    <label>Forma de Pagamento:</label><br />
    <select name="pagamento" required>
      <option value="Dinheiro">Dinheiro</option>
      <option value="Transferência">Transferência</option>
      <option value="Cartão">Cartão</option>
    </select><br /><br />
    
    <button type="submit">📄 Confirmar Pedido</button>
  </form>
</div>

<!-- Resultado -->
<div id="resultadoPedido" style="margin-top:20px; font-weight: bold;"></div>

<script>
// Mostrar formulário ao clicar no botão
document.getElementById('btnFazerPedido').addEventListener('click', function () {
    document.getElementById('formularioPedido').style.display = 'block';
});

// Envio AJAX
document.getElementById('pedidoForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('acao', '');

    fetch('fazer_pedido.php', {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.text())
    .then(data => {
        document.getElementById('resultadoPedido').innerHTML = data;
        document.getElementById('formularioPedido').style.display = 'none';
    })
    .catch(err => {
        document.getElementById('resultadoPedido').innerHTML = '❌ Erro ao enviar pedido.';
    });
});
</script>
