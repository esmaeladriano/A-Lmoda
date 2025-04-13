<?php
session_start();
include_once('conexao.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "⚠️ Acesso não autorizado.";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Cancelar pedido
if (isset($_GET['cancelar']) && is_numeric($_GET['cancelar'])) {
    $pedido_id = $_GET['cancelar'];

    // Verifica se é do usuário e está pendente
    $sql = "SELECT * FROM pedidos WHERE id = ? AND id_usuario = ? AND status = 'pendente'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $pedido_id, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows) {
        $sql = "UPDATE pedidos SET status = 'cancelado' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pedido_id);
        $stmt->execute();
        echo "<script>alert('Pedido cancelado com sucesso!');window.location='meus_pedidos.php';</script>";
        exit;
    }
}

// Listar pedidos
$sql = "SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY data_pedido DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Meus Pedidos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">🧾 Meus Pedidos</h2>
    <?php if ($result->num_rows > 0): ?>
      <?php while ($pedido = $result->fetch_assoc()): ?>
        <div class="card mb-4 shadow-sm">
          <div class="card-body">
            <h5>📦 Pedido #<?= $pedido['id'] ?> | <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></h5>
            <p>Status: <strong><?= ucfirst($pedido['status']) ?></strong></p>
            <p>Total: <strong><?= number_format($pedido['total'], 2, ',', '.') ?> Kz</strong></p>

            <h6>Itens:</h6>
            <ul>
              <?php
                $sqlItens = "SELECT ip.*, p.nome FROM itens_pedido ip
                             JOIN produtos p ON p.id = ip.id_produto
                             WHERE ip.id_pedido = ?";
                $stmtItens = $conn->prepare($sqlItens);
                $stmtItens->bind_param("i", $pedido['id']);
                $stmtItens->execute();
                $resItens = $stmtItens->get_result();
                while ($item = $resItens->fetch_assoc()):
              ?>
                <li><?= $item['nome'] ?> - <?= $item['quantidade'] ?>x (<?= number_format($item['preco_unitario'], 2, ',', '.') ?> Kz)</li>
              <?php endwhile; ?>
            </ul>

            <?php if ($pedido['status'] === 'pendente'): ?>
              <a href="?cancelar=<?= $pedido['id'] ?>" class="btn btn-danger btn-sm mt-2">❌ Cancelar Pedido</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="alert alert-info">Você ainda não tem pedidos.</div>
    <?php endif; ?>
  </div>
</body>
</html>
