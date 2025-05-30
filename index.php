<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Home Page</title>

    <script src="app.js"></script>
    <link rel="stylesheet" href="./assets/css/index.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


</head>

<body class="cor-fundo">

    <?php
    include_once('./navbar.php');

    ?>



    <?php include_once('./slider.php') ?>

    <?php include_once('./Produtos.php') ?>
    <?php include_once('./produtosCategorias.php') ?>
    <?php include_once('./testemunho.php') ?>


    <!-----------------------------------brands----------------------------->
    <div class="brands container my-5">
        <h2 class="text-center mb-4"> Patrocino</h2>
        <div class="small-container">
            <div class="brand-slider position-relative">
                <div class="row flex-nowrap overflow-auto" id="brandSlider" style="scroll-behavior: smooth;">
                    <?php
                    // Conexão com banco
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "loja_online";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        echo '<p class="text-center w-100">Erro na conexão: ' . $conn->connect_error . '</p>';
                    }
                    // Fetch brands from the database
                    $sql = "SELECT logo, nome FROM marcas";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data for each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-6 col-sm-4 col-md-2 d-flex justify-content-center align-items-center brand-item">';
                            echo '<div class="brand-logo-box">';
                            echo '<img src="http://localhost/A&Lmoda/painel/admin/uploads/' . htmlspecialchars($row['logo']) . '" alt="' . htmlspecialchars($row['nome']) . '" class="img-fluid">';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No brands available.</p>';
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        body{
            
            background-color: #ffffff;
        }
        .brand-slider {
            position: relative;
        }
        .brand-item {
            min-width: 140px;000
            max-width: 180px;
            padding: 20px 10px;
            transition: transform 0.3s;
        }
        .brand-logo-box {
            
            border-radius: 16px;
            background-color: #ffff;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(224,194,23,0.08);
            transition: box-shadow 0.2s, border-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px;
        }
        .brand-logo-box img {
            max-height: 60px;
            max-width: 100px;
            object-fit: contain;
            filter: grayscale(0.2);
            transition: filter 0.2s, transform 0.2s;
        }
        .brand-logo-box:hover {
            border-color: #00FF66;
            box-shadow: 0 4px 16px rgba(224,194,23,0.18);
        }
        .brand-logo-box:hover img {
            filter: none;
            transform: scale(1.08);
        }
        @media (max-width: 767px) {
            .brand-item {
                min-width: 110px;
                max-width: 130px;
                padding: 10px 4px;
            }
            .brand-logo-box {
                height: 70px;
                padding: 8px;
            }
            .brand-logo-box img {
                max-height: 40px;
                max-width: 60px;
            }
        }
    </style>
    <script>
        // Slider automático para marcas
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('brandSlider');
            let scrollAmount = 0;
            let direction = 1;

            function autoSlideBrands() {
                if (!slider) return;
                const item = slider.querySelector('.brand-item');
                if (!item) return;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                const step = item.offsetWidth;

                if (direction === 1 && scrollAmount + step >= maxScroll) {
                    direction = -1;
                } else if (direction === -1 && scrollAmount - step <= 0) {
                    direction = 1;
                }

                scrollAmount += direction * step;
                slider.scrollTo({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }

            setInterval(autoSlideBrands, 2200);
        });
    </script>

    <!--------------------------------------footer----------------------------------->
    <footer class="footer mt-5 py-4 bg-secondary">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 class="mb-3" style="color: #f7f7f7;">Baixe Nosso App</h5>
                    <p>Disponível para Android e iOS.</p>
                    <div class="d-flex gap-2">
                        <img src="./rodap.img/play-store.png" alt="Play Store" class="img-fluid" style="max-width: 110px;">
                        <img src="./rodap.img/app-store.png" alt="App Store" class="img-fluid" style="max-width: 110px;">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 class="mb-3" style="color:#f7f7f7;">Sobre</h5>
                    <div class="logo mb-2">
                        <a href="index.php" style="text-decoration: none;">
                            <div class="marca_empresa">
                                <b style="color: #f7f7f7; font-size: 1.5rem;">A&L</b>
                                <b style="color: #ff0000; font-size: 1.5rem;"> MODEL</b>
                            </div>
                        </a>
                    </div>
                    <p style="font-size: 0.95rem;">Nossa missão é tornar o prazer e os benefícios da moda acessíveis a todos.</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 class="mb-3" style="color: #f7f7f7;">Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Cupons</a></li>
                        <li><a href="#" class="footer-link">Blog</a></li>
                        <li><a href="#" class="footer-link">Política de Devolução</a></li>
                        <li><a href="#" class="footer-link">Afiliados</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h5 class="mb-3" style="color: ;">Redes Sociais</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="https://www.facebook.com" target="_blank" class="footer-link"><i class="bi bi-facebook"></i> Facebook</a></li>
                        <li><a href="https://www.twitter.com" target="_blank" class="footer-link"><i class="bi bi-twitter"></i> Twitter</a></li>
                        <li><a href="https://www.instagram.com" target="_blank" class="footer-link"><i class="bi bi-instagram"></i> Instagram</a></li>
                        <li><a href="https://www.youtube.com" target="_blank" class="footer-link"><i class="bi bi-youtube"></i> YouTube</a></li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: #ff0000;">
            <p class="text-center mb-0" style="color: #222;">&copy; 2025 - A&L MODA</p>
        </div>
    </footer>
    <style>
        .footer-link {
            color: #222;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-link:hover {
            color:rgb(0, 255, 213);
            text-decoration: underline;
        }
        .footer {
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        a{
            text-decoration: none;
            color: black;
        }
        @media (max-width: 767px) {
            .footer .marca_empresa b {
                font-size: 1.2rem !important;
            }
            .footer .container {
                padding-left: 10px;
                padding-right: 10px;
            }
        }
    </style>

    <script src="./assets/js/bootstrap.bundle.js"></script>
    <script src="app.js"></script>



</body>

</html>