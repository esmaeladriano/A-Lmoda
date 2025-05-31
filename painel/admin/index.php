<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
  header("Location: ../../login/");
  exit();
}
?>

<?php
include_once('../../conexao.php');
// Consultas para obter os dados
$queryProdutos = "SELECT COUNT(*) AS total FROM produtos";
$queryVendas = "SELECT COUNT(*) AS total FROM vendas";
$queryClientes = "SELECT COUNT(*) AS total FROM usuarios";
$queryTestemunhos = "SELECT COUNT(*) AS total FROM depoimentos";
$queryMarcas = "SELECT COUNT(*) AS total FROM marcas";
$queryCategorias = "SELECT COUNT(*) AS total FROM categorias";

$totalProdutos = $conn->query($queryProdutos)->fetch_assoc()['total'];
$totalVendas = $conn->query($queryVendas)->fetch_assoc()['total'];
$totalClientes = $conn->query($queryClientes)->fetch_assoc()['total'];
$totalTestemunhos = $conn->query($queryTestemunhos)->fetch_assoc()['total'];
$totalMarcas = $conn->query($queryMarcas)->fetch_assoc()['total'];
$totalCategorias = $conn->query($queryCategorias)->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
  <meta charset="UTF-8">
  <title>Painel Administrativo - A&L Moda</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

  <?php include_once('./navbar.php'); ?>
  <!-- 🧾 Conteúdo -->
  <div class="main-content" style="margin-top: 56px;">
    <div class="container-fluid">
      <h1 class="mb-4">Bem-vindo, <?= $_SESSION['usuario_nome'] ?>? 👋</h1>
      <p>Painel administrativo da A&L Moda. Veja abaixo os destaques da loja:</p>


      <!-- 📊 Cards Estatísticos -->
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <a href="./produtos.php" class="text-decoration-none">
        <div class="card text-white bg-secondary">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
          <h5 class="card-title">Produtos</h5>
          <h2><?= $totalProdutos ?></h2>
            </div>
            <i class="bi bi-bag-fill fs-1"></i>
          </div>
        </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="./vendas.php" class="text-decoration-none">
        <div class="card text-white" style="background-color: #6c757d;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
          <h5 class="card-title">Vendas</h5>
          <h2>KZ <?= number_format($totalVendas, 2, ',', '.') ?></h2>
            </div>
          </div>
        </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="./usuarios.php" class="text-decoration-none">
        <div class="card text-white" style="background-color: #868e96;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
          <h5 class="card-title">Clientes</h5>
          <h2><?= $totalClientes ?></h2>
            </div>
            <i class="bi bi-people-fill fs-1"></i>
          </div>
        </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="./depoimentos.php" class="text-decoration-none">
        <div class="card text-white" style="background-color: #adb5bd;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
          <h5 class="card-title">Depoimentos</h5>
          <h2><?= $totalTestemunhos ?></h2>
            </div>
            <i class="bi bi-chat-left-text-fill fs-1"></i>
          </div>
        </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="./marcas.php" class="text-decoration-none">
        <div class="card text-white" style="background-color: #ced4da;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
          <h5 class="card-title">Marcas</h5>
          <h2><?= $totalMarcas ?></h2>
            </div>
            <i class="bi bi-tags-fill fs-1"></i>
          </div>
        </div>
          </a>
        </div>
        <div class="col-md-4">
          <a href="./categorias.php" class="text-decoration-none">
        <div class="card text-dark" style="background-color: #dee2e6;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
          <h5 class="card-title">Categorias</h5>
          <h2><?= $totalCategorias ?></h2>
            </div>
            <i class="bi bi-grid-fill fs-1"></i>
          </div>
        </div>
          </a>
        </div>
      </div>
    </div>

    <!-- Vamos adicionar o grafica das vendas -->
  


  </div>
  </div>

  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>