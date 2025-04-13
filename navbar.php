<?php 
// session_start();
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
$totalItensCarrinho = 0;


if (isset($_SESSION['usuario_id'])) {
    $id_usuario =$_SESSION['usuario_id'];

    $sql = "SELECT COUNT(*) FROM `carrinho` WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();

    $totalItensCarrinho = $total ?? 0;
   
}
?>

<!-- BARRA DE ÍCONES -->
<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between px-4 shadow-sm">
    <div class="d-flex align-items-center gap-3">
        <i class="bi bi-facebook" style="font-size: 25px;"></i> <!-- Ícone Facebook -->
        <i class="bi bi-instagram" style="font-size: 25px;"></i> <!-- Ícone Instagram -->
        <i class="bi bi-twitter" style="font-size: 25px;"></i> <!-- Ícone Twitter -->
    </div>

    <div class="d-flex align-items-center gap-4">
        <?php if (!empty($_SESSION['email'])): ?>
            <span class="text-dark me-3">
                👤 <?= isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : htmlspecialchars($_SESSION['email']) ?>
            </span>
            <a href="./login/exit.php" class="btn btn-danger btn-sm">Sair</a>
        <?php else: ?>
            <a href="./cadastro/"
                class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2">Cadastro</a>
            <a href="./login/" class="btn btn-outline-secondary btn-sm rounded-pill px-4 py-2">Login</a>
        <?php endif; ?>
    </div>
</nav>


<!-- LOGO E PESQUISA -->
<div class="container-fluid py-1 text-center bg-white border-bottom shadow-lg">
    <h5 class="mb-1 display-3 text-primary fw-bold">🛍️ A&L MODA</h5>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <div class="position-relative w-50">
            <input type="text" class="form-control rounded-pill px-4 py-3" placeholder="🔍 Pesquise aqui...">
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">
                <button class="btn btn-warning rounded-circle">
                    <i class="bi bi-search"></i>
                </button>
            </span>
        </div>
        <a href="carrinho.php" class="btn btn-warning rounded-pill d-flex align-items-center gap-2">
            🛒 <span class="badge bg-danger"><?= $totalItensCarrinho ?></span>
        </a>

    </div>
</div>

<!-- SEGUNDA NAVEGAÇÃO -->
<nav class="bg-dark">
    <ul class="nav justify-content-center ">
        <li class="nav-item">
            <a class="nav-link text-white" href="">
                <i class="bi bi-house-door-fill"></i> 🏠 Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="./beleza.php">
                <i class="bi bi-lipstick"></i> 💄 Beleza
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="./bousa.php">
                <i class="bi bi-bag"></i> 👜 Bolsa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="./sapato.php">
                <i class="bi bi-shoe-print"></i> 👠 Sapato
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="./saia.php">
                <i class="bi bi-dress"></i> 👗 Saias
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="./calças.php">
                <i class="bi bi-file-earmark"></i> 👗 Vestido
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="./blusa.php">
                <i class="bi bi-shirt"></i> 👚 Blusas
            </a>
        </li>
    </ul>
</nav>

<!-- Biblioteca de Ícones Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">