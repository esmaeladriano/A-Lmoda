<?php
// Conexão com o banco
include 'conexao.php';

// Busca os produtos em destaque
$consulta = $conn->query("SELECT * FROM produtos WHERE destaque = 1 ORDER BY data_adicao DESC LIMIT 5");
$produtosDestaque = $consulta->fetch_all(MYSQLI_ASSOC);
?>

<!-- HERO SLIDER DINÂMICO -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    
    <!-- Indicadores -->
    <div class="carousel-indicators">
        <?php foreach ($produtosDestaque as $index => $produto): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                class="<?= $index == 0 ? 'active' : '' ?>" aria-current="<?= $index == 0 ? 'true' : 'false' ?>" 
                aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach ($produtosDestaque as $index => $produto): ?>
        <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
            <img src="http://localhost/A&Lmoda/painel/admin/uploads/<?= $produto['imagem'] ?>" class="d-block w-100"
                alt="<?= $produto['nome'] ?>" style="height: 500px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInUp bg-dark bg-opacity-50 p-3 rounded">
                <h5 class="fw-bold text-warning">✨ <?= $produto['nome'] ?></h5>
                <p><?= mb_strimwidth($produto['descricao'], 0, 100, '...') ?></p>
                <p><strong class="text-light">💰 <?= number_format($produto['preco'], 2, ',', '.') ?> Kz</strong></p>
                <button class="btn btn-success btn-sm btn-adicionar" 
                        data-id="<?= $produto['id'] ?>"
                        data-nome="<?= $produto['nome'] ?>"
                        data-preco="<?= $produto['preco'] ?>"
                        data-imagem="<?= $produto['imagem'] ?>">
                    🛒 Adicionar ao Carrinho
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>
