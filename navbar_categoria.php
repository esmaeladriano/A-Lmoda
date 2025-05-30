
<style>
.cor-fundo{
    background-color: #fff;
}


</style>

<?php
// session_start();
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
$totalItensCarrinho = 0;


if (isset($_SESSION['usuario_id'])) {
    $id_usuario = $_SESSION['usuario_id'];

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
 <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<!-- BARRA DE ÍCONES -->
<nav class="navbar navbar-expand-lg navbar-light bg-secondary justify-content-between px-4 shadow-sm">
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
                class="btn btn-primary btn-sm rounded-pill px-4 py-2">Cadastro</a>
            <a href="./login/" class="btn btn-primary btn-sm rounded-pil btn-sm rounded-pill px-4 py-2">Login</a>
        <?php endif; ?>
    </div>
</nav>


<!-- LOGO E PESQUISA -->
<div class="container-fluid py-1 text-center bg-white border-bottom shadow-lg">
    <h5 class="mb-1 display-3 text-primary fw-bold">🛍️ A&L MODA</h5>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <div class="position-relative w-50">
            <input type="text" id="search-bar" class="form-control rounded-pill px-4 py-3" placeholder="🔍 Pesquise aqui...">
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3">
                <button class="btn btn-secondary rounded-circle">
                    <i class="bi bi-search"></i>
                </button>
            </span>
            <div id="search-results" class="position-absolute w-100 bg-white border rounded mt-1" style="z-index: 1000; display: none;"></div>
        </div>


        <a href="carrinho.php" class="btn btn-secondary rounded-pill d-flex align-items-center gap-2">
            🛒 <span class="badge bg-danger"><?= $totalItensCarrinho ?></span>
        </a>

    </div>
</div>

<!-- SEGUNDA NAVEGAÇÃO -->
<nav class="bg-secondary">
    <ul class="nav justify-content-center ">
      
    <li class="nav-item">
            <a class="nav-link text-white" href="http://localhost/A&Lmoda/">
                <i class="bi bi-lipstick"></i> HOME
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="http://localhost/A&Lmoda/Beleza.php">
                <i class="bi bi-lipstick"></i> BELEZA
            </a>
        </li>
    
        <li class="nav-item">
            <a class="nav-link text-white" href="http://localhost/A&Lmoda/Sapato.php">
                <i class="bi bi-shoe-print"></i> SAPATO
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="http://localhost/A&Lmoda/Saias.php">
                <i class="bi bi-dress"></i> SAIA
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="http://localhost/A&Lmoda/Vestido.php">
                <i class="bi bi-dress"></i>  VESTIDO
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="http://localhost/A&Lmoda/Bolsa.php">
                <i class="bi bi-dress"></i>  BOLSA
            </a>
        </li>
     
    </ul>
</nav>

<!-- Biblioteca de Ícones Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search-bar').on('keyup', function() {
            let query = $(this).val().trim();

            if (query.length > 0) {
                $.ajax({
                    url: 'search.php',
                    method: 'GET',
                    data: { q: query },
                    success: function(data) {
                        console.log(data);
                        try {
                            let results = JSON.parse(data);
                            console.log(results);
                            // Customize the display of results as needed
                            // let html = `<div class="result-item p-2 border-bottom">${results}</div>`;
                            // $('#search-results').html(html).show();
                        } catch (e) {
                            console.error('Error processing results:', e);
                            $('#search-results').html('<div class="p-2 text-danger">Error processing results.</div>').show();
                        }
                    },
                    error: function() {
                        $('#search-results').html('<div class="p-2 text-danger">Error fetching results.</div>').show();
                    }
                });
            } else {
                $('#search-results').hide();
            }
        });

        // Hide results when clicking outside the search bar or results container
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#search-bar, #search-results').length) {
                $('#search-results').hide();
            }
        });
    });
</script>