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

<body>

    <?php
    include_once('./navbar.php');

    ?>

    <!-- SLIDER / HERO -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicadores -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://images.pexels.com/photos/12512195/pexels-photo-12512195.jpeg" class="d-block w-100"
                    alt="Produto 1">
                <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInUp">
                    <h5 class="fw-bold">🌟 Nova Coleção 2025</h5>
                    <p>Estilo, Elegância e Tendência em um só lugar.</p>
                    <a href="#comprar" class="btn btn-warning">🛍️ Ver Produtos</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/7679732/pexels-photo-7679732.jpeg" class="d-block w-100"
                    alt="Produto 2">
                <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInUp">
                    <h5 class="fw-bold">👠 Elegância e Charme</h5>
                    <p>Confira os sapatos que estão a conquistar o mundo.</p>
                    <p><strong>Preço: R$ 250,00</strong></p>
                    <button class="btn btn-success">Adicionar ao Carrinho</button>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/5886041/pexels-photo-5886041.jpeg" class="d-block w-100"
                    alt="Produto 3">
                <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInUp">
                    <h5 class="fw-bold">👜 Bolsas Exclusivas</h5>
                    <p>Luxo e praticidade para o seu dia a dia.</p>
                    <p><strong>Preço: R$ 300,00</strong></p>
                    <button class="btn btn-success">Adicionar ao Carrinho</button>
                </div>
            </div>
        </div>

        <!-- Botões de Navegação -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>

    <?php include_once('./Produtos.php') ?>


    <!------------testmonial--------------->
    <div class="testimonial container justify-content-center">
        <div class="small-container">
            <div class="row">
                <div class="col teste">
                    <i class="fas fa-quote-left"></i>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <img src="img/user-2.png" alt="User Image">
                    <h3>Mike McBean</h3>
                </div>

                <div class="col teste mx-2">
                    <i class="fas fa-quote-left"></i>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <img src="img/user-1.png" alt="User Image">
                    <h3>Sean Parker</h3>
                </div>

                <div class="col teste">
                    <i class="fas fa-quote-left"></i>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <img src="img/user-3.png" alt="User Image">
                    <h3>Susan Hopister</h3>
                </div>
            </div>
        </div>
    </div>

    <!-----------------------------------brands----------------------------->
    <div class="brands container">
        <div class="small-container">
            <div class="row">
                <div class="col-6 col-sm-4 col-md-2 parto">
                    <img src="img/logo-godrej.png" alt="Godrej" class="img-fluid">
                </div>
                <div class="col-6 col-sm-4 col-md-2 parto">
                    <img src="img/logo-oppo.png" alt="Oppo" class="img-fluid">
                </div>
                <div class="col-6 col-sm-4 col-md-2 parto">
                    <img src="img/logo-coca-cola.png" alt="Coca-Cola" class="img-fluid">
                </div>
                <div class="col-6 col-sm-4 col-md-2 parto">
                    <img src="img/logo-paypal.png" alt="Paypal" class="img-fluid">
                </div>
                <div class="col-6 col-sm-4 col-md-2 parto">
                    <img src="img/logo-philips.png" alt="Philips" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------footer---------------------------->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3 footer-col-1">
                    <h3>Download Our App</h3>
                    <p>Download App For Android and iOS mobile phones.</p>
                    <div class="app-logo">
                        <img src="./rodap.img/play-store.png" alt="Play Store" class="img-fluid">
                        <img src="./rodap.img/app-store.png" alt="App Store" class="img-fluid">
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 footer-col-2">
                    <h3>Sobre</h3>
                    <div class="logo">
                        <a href="index.html">
                            <div class="marca_empresa">
                                <b style="color: #f7f7f7;">A&L</b> <b style="color: #ff0000;"> MODEL</b>
                            </div>
                        </a>
                    </div>
                    <p>Our Purpose Is To Sustainably Make The Pleasure And Benefits Of Sport Accessible to the Many.</p>
                </div>

                <div class="col-12 col-md-6 col-lg-3 footer-col-3">
                    <h3>Links Úteis</h3>
                    <ul>
                        <li><a href="#">Coupons</a></li>
                        <li><a href="#">Blog Post</a></li>
                        <li><a href="#">Return Policy</a></li>
                        <li><a href="#">Join Affiliate</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-6 col-lg-3 footer-col-4">
                    <h3>Redes Sociais</h3>
                    <ul>
                        <li><a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i>
                                Facebook</a></li>
                        <li><a href="https://www.twitter.com" target="_blank"><i class="bi bi-twitter"></i> Twitter</a>
                        </li>
                        <li><a href="https://www.instagram.com" target="_blank"><i class="bi bi-instagram"></i>
                                Instagram</a></li>
                        <li><a href="https://www.youtube.com" target="_blank"><i class="bi bi-youtube"></i> YouTube</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="Copyright">Copyright 2025 - A&L MODA</p>
        </div>
    </div>

    <script src="./assets/js/bootstrap.bundle.js"></script>
    <script src="app.js"></script>
 


</body>

</html>