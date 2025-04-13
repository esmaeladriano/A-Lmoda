<!-- 🔝 Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🛍️ A&L Moda - Admin</a>

    <div class="ms-auto text-white me-3 d-none d-md-block">
      👤 <?= isset($_SESSION['nome_usuario']) ? $_SESSION['nome_usuario'] : 'Usuário' ?>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- 📚 Sidebar -->
<div class="sidebar position-fixed top-0 start-0 d-flex flex-column" style="width:250px; margin-top: 56px;">
  <a href="./index.php" class="active"><i class="bi bi-house-door"></i> Início</a>
  <a href="produtos.php"><i class="bi bi-box"></i> Produtos</a>
  <a href="vendas.php"><i class="bi bi-cart-check"></i> Vendas</a>
  <a href="./usuarios.php"><i class="bi bi-person"></i> Usuários</a>
  <a href="depoimentos.php"><i class="bi bi-chat-dots"></i> Testemunhos</a>
  <a href="categorias.php"><i class="bi bi-tags"></i> Categorias</a>
  <a href="marcas.php"><i class="bi bi-building"></i> Marcas (Brands)</a>
  <a href="#"><i class="bi bi-gear"></i> Configurações</a>
  <a href="../../login/exit.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
</div>
<style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      height: calc(100vh - 56px);
      background-color: #343a40;
      color: white;
      padding-top: 1rem;
    }

    .sidebar a {
      color: #adb5bd;
      display: block;
      padding: 0.75rem 1rem;
      text-decoration: none;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color: #495057;
      color: white;
    }

    .main-content {
      margin-left: 250px;
      padding: 2rem;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        width: 200px;
        z-index: 1000;
        height: 100vh;
      }

      .main-content {
        margin-left: 0;
      }
    }
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a2e0b45b2f.js" crossorigin="anonymous"></script>