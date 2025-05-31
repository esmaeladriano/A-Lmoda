<?php
include_once 'conexao.php'; // Inclui o arquivo de conexão

function getProdutosPorCategoria($conn, $categoria)
{
    $categoria = mysqli_real_escape_string($conn, $categoria);

    $sql = "SELECT * FROM `produtos` p 
            JOIN categorias c ON p.categoria_id = c.id 
            WHERE c.nome = '$categoria' AND  p.destaque = 0
            ORDER BY p.data_adicao DESC
             limit 6";

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

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Produtos por Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 40px 200px gray;
            transition: transform 0.7s ease, box-shadow 4.3s ease;
            cursor: pointer;
            width: 100%;

        }
        /* Estilo personalizado para botão "Adicionar ao Carrinho" */
        .btn-custom {
            background-color: #ff7;
            /* Laranja vibrante */
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #cc6;
            /* Laranja escuro no hover */
            color: white;
        }

        /* Imagens dos cards com tamanho fixo e animação */
        .card-img-fixed {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card-img-fixed:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <div class="container mt-2">
        <h1 class="text-center mb-4">🛍️ Produtos por Categoria</h1>

        <section id="beleza" class="mb-4 animate-on-scroll">
            <h2 class="text-capitalize text-center">Beleza</h2>
            <div class="row">
                <?php
                $produtos = getProdutosPorCategoria($conn, "beleza");
                foreach ($produtos as $produto) {
                    echo '<div class="col-6 col-sm-4 col-md-2 mb-3">'; // 6 colunas por linha
                    echo '<div class="card shadow-sm">';
                    echo '<img class="card-img-top" style="height: 120px; object-fit: cover;" src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
                    echo '<div class="card-body p-2">';
                    echo '<h6 class="card-title text-secondary mb-1" style="font-size: 14px;">📁 ' . $produto['nome'] . '</h6>';
                    echo '<span class="badge bg-success">💰' . number_format($produto['preco'], 2, ',', 'KZ') . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <center>
                <a href="http://localhost/A&Lmoda/Beleza.php">
                    <button class="btn btn-primary btn-sm mt-2">Ver mais</button>
                </a>
            </center>
        </section>

        <!-- Sapato -->
        <section id="sapato" class="mb-4 animate-on-scroll">
            <h2 class="text-capitalize text-center">Sapato</h2>
            <div class="row">
                <?php
                $produtos = getProdutosPorCategoria($conn, "sapato");
                foreach ($produtos as $produto) {
                    echo '<div class="col-6 col-sm-4 col-md-2 mb-3">'; // 6 colunas por linha
                    echo '<div class="card shadow-sm">';
                    echo '<img class="card-img-top" style="height: 120px; object-fit: cover;" src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
                    echo '<div class="card-body p-2">';
                    echo '<h6 class="card-title text-secondary mb-1" style="font-size: 14px;">📁 ' . $produto['nome'] . '</h6>';
                    echo '<span class="badge bg-success">💰' . number_format($produto['preco'], 2, ',', 'KZ') . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <center>
                <a href="http://localhost/A&Lmoda/Sapato.php">
                    <button class="btn btn-primary btn-sm mt-2">Ver mais</button>
                </a>
            </center>
        </section>

        <!-- Saias -->
        <section id="saia" class="mb-4 animate-on-scroll">
            <h2 class="text-capitalize text-center">Saias</h2>
            <div class="row">
                <?php
                $produtos = getProdutosPorCategoria($conn, "saia");
                foreach ($produtos as $produto) {
                    echo '<div class="col-6 col-sm-4 col-md-2 mb-3">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" style="height: 120px; object-fit: cover;" src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-secondary"> 📁 ' . $produto['nome'] . '</h5>';
                    echo '<p class="card-text badge bg-success"> 💰' . number_format($produto['preco'], 2, ',', 'KZ') . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <center>
                <a href="http://localhost/A&Lmoda/Saias.php">
                    <button class="btn btn-primary btn-sm mt-2">Ver mais</button>
                </a>
            </center>
        </section>

        <!-- Vestido -->
        <section id="vestido" class="mb-4 animate-on-scroll">
            <h2 class="text-capitalize text-center">Vestido</h2>
            <div class="row">
                <?php
                $produtos = getProdutosPorCategoria($conn, "vestido");
                foreach ($produtos as $produto) {
                    echo '<div class="col-6 col-sm-4 col-md-2 mb-3">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" style="height: 120px; object-fit: cover;" src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-secondary"> 📁 ' . $produto['nome'] . '</h5>';
                    echo '<p class="card-text badge bg-success"> 💰' . number_format($produto['preco'], 2, ',', 'KZ') . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <center>
                <a href="http://localhost/A&Lmoda/Vestido.php">
                    <button class="btn btn-primary btn-sm mt-2">Ver mais</button>
                </a>
            </center>
        </section>

        <!-- Bolsa -->
        <section id="bolsa" class="mb-4 animate-on-scroll">
            <h2 class="text-capitalize text-center">Bolsa</h2>
            <div class="row">
                <?php
                $produtos = getProdutosPorCategoria($conn, "BOLSA");
                foreach ($produtos as $produto) {
                    echo '<div class="col-6 col-sm-4 col-md-2 mb-3">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" style="height: 120px; object-fit: cover;" src="http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-secondary"> 📁 ' . $produto['nome'] . '</h5>';
                    echo '<p class="card-text badge bg-success"> 💰' . number_format($produto['preco'], 3, ',', 'KZ') . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <center>
                <a href="http://localhost/A&Lmoda/Bolsa.php">
                    <button class="btn btn-primary btn-sm mt-2">Ver mais</button>
                </a>
            </center>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>