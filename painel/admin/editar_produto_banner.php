<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("SELECT * FROM produtos_baner WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows > 0) {
    $produto = $resultado->fetch_assoc();
    echo json_encode($produto);
  } else {
    echo json_encode(['erro' => 'Produto não encontrado']);
  }
}
?>
