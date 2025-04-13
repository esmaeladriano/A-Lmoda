<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: ../../login/");
    exit();
}
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

<?php include_once ('./navbar.php');?>
<!-- 🧾 Conteúdo -->
<div class="main-content" style="margin-top: 56px;">
  <div class="container-fluid">
    <h1 class="mb-4">Bem-vindo, <?= $_SESSION['usuario_nome'] ?> 👋</h1>
    <p>Painel administrativo da A&L Moda. Veja abaixo os destaques da loja:</p>

    <!-- 📊 Cards Estatísticos -->
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Produtos</h5>
              <h2>120</h2>
            </div>
            <i class="bi bi-bag-fill fs-1"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Vendas</h5>
              <h2>R$ 5.320</h2>
            </div>
            <i class="bi bi-currency-dollar fs-1"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-danger shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Clientes</h5>
              <h2>87</h2>
            </div>
            <i class="bi bi-people-fill fs-1"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Testemunhos</h5>
              <h2>16</h2>
            </div>
            <i class="bi bi-chat-left-text-fill fs-1"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-info shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Marcas</h5>
              <h2>22</h2>
            </div>
            <i class="bi bi-tags-fill fs-1"></i>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-secondary shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title">Categorias</h5>
              <h2>12</h2>
            </div>
            <i class="bi bi-grid-fill fs-1"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- 📊 Gráfico de Vendas -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="bi bi-bar-chart-fill"></i> Vendas Mensais</h5>
        <canvas id="graficoVendas" height="100"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoVendas').getContext('2d');
const grafico = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
    datasets: [{
      label: 'Vendas (R$)',
      data: [1200, 1500, 1800, 1000, 2200, 2700],
      backgroundColor: 'rgba(13, 110, 253, 0.7)',
      borderRadius: 8
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
