<?php
include_once 'conexao.php'; // Inclui o arquivo de conexão

function getProdutosPorCategoria($conn, $categoria)
{
    // Escapa a string para evitar SQL Injection
    $categoria = mysqli_real_escape_string($conn, $categoria);

    $sql = "SELECT * FROM `produtos` p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE c.nome = '$categoria'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $produtos;
    } else {
        return [];
    }
}
?>
<div class="container mt-5">
    <!-- Sessão Beleza -->
    <section id="beleza">
        <h2>💄 Beleza</h2>
        <div class="row">
            <?php
            $produtos = getProdutosPorCategoria($conn, "beleza");
            foreach ($produtos as $produto) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" class="card-img-top" alt="' . $produto['nome'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $produto['nome'] . '</h5>';
                echo '<p class="card-text">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <!-- Sessão Bolsa -->
    <section id="bolsa"></section>
    </section>
    <h2>👜 Bolsa</h2>
    <div class="row">
        <?php
        $produtos = getProdutosPorCategoria($conn, "bolsa");
        foreach ($produtos as $produto) {
            echo '<div class="col-md-3">';
            echo '<div class="card">';
            echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" class="card-img-top" alt="' . $produto['nome'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $produto['nome'] . '</h5>';
            echo '<p class="card-text">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    </section>

    <!-- Sessão Sapato -->
    <section id="sapato"></section>
    </section>
    <h2>👠 Sapato</h2>
    <div class="row">
        <?php
        $produtos = getProdutosPorCategoria($conn, "sapato");
        foreach ($produtos as $produto) {
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" class="card-img-top" alt="' . $produto['nome'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $produto['nome'] . '</h5>';
            echo '<p class="card-text">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    </section>

    <!-- Sessão Saias -->
    <section id="saias">
        <h2>👗 Saias</h2>
        <div class="row">
            <?php
            $produtos = getProdutosPorCategoria($conn, "saias");
            foreach ($produtos as $produto) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" class="card-img-top" alt="' . $produto['nome'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $produto['nome'] . '</h5>';
                echo '<p class="card-text">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <!-- Sessão Vestido -->
    <section id="vestido">
        <h2>👗 Vestido</h2>
        <div class="row">
            <?php
            $produtos = getProdutosPorCategoria($conn, "vestido");
            foreach ($produtos as $produto) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" class="card-img-top" alt="' . $produto['nome'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $produto['nome'] . '</h5>';
                echo '<p class="card-text">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <!-- Sessão Blusas -->
    <section id="blusas">
        <h2>👕 Blusas</h2>
        <div class="row">
            <?php
            $produtos = getProdutosPorCategoria($conn, "blusas");
            foreach ($produtos as $produto) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
            echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" class="card-img-top" alt="' . $produto['nome'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $produto['nome'] . '</h5>';
                echo '<p class="card-text">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
</div>

<?php $conn->close(); ?>