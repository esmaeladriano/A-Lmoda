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
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --rosa-claro: #fff0f5;
            --rosa: #e91e63;
            --rosa-escuro: #d63384;
            --amarelo: #ffc107;
            --preto: #1a1a1a;
            --cinza-claro: #f9f9f9;
            --cinza-medio: #ccc;
            --cinza-escuro: #444;
            --branco: #ffffff;
            --transparente-preto: rgba(0, 0, 0, 0.5);
        }

        /* ======= TESTEMUNHOS ======= */
        .testimonial {
            background-color: var(--rosa-claro);
            padding: 60px 20px;
            text-align: center;
        }

        .testimonial .small-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .testimonial .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .testimonial .col.teste {
            background: var(--branco);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 320px;
            flex: 1;
            transition: transform 0.3s ease;
        }

        .testimonial .col.teste:hover {
            transform: translateY(-10px);
        }

        .testimonial .fa-quote-left {
            font-size: 24px;
            color: var(--rosa);
            margin-bottom: 10px;
        }

        .testimonial p {
            font-style: italic;
            font-size: 15px;
            color: var(--cinza-escuro);
            margin: 15px 0;
        }

        .testimonial h3 {
            margin-top: 10px;
            font-weight: bold;
            color: var(--rosa-escuro);
            font-size: 18px;
        }

        .testimonial img {
            width: 60px;
            height: 60px;
            margin-top: 15px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--rosa);
        }

        .rating i {
            color: var(--amarelo);
            margin: 0 1px;
        }

        /* ======= CARROSSEL ======= */
        .carousel-caption {
            background: var(--transparente-preto);
            border-radius: 15px;
            padding: 20px;
        }

        .carousel img {
            object-fit: cover;
            height: 500px;
        }

        @media (max-width: 768px) {
            .carousel img {
                height: 300px;
            }
        }

        /* ======= MARCAS ======= */
        .brands {
            padding: 60px 20px;
            background-color: var(--cinza-claro);
            text-align: center;
        }

        .brands .small-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .brands .parto {
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .brands .parto:hover {
            transform: scale(1.1);
            filter: brightness(1.1);
        }

        .brands img {
            max-width: 100px;
            height: auto;
            opacity: 0.85;
            transition: opacity 0.3s ease;
        }

        .brands img:hover {
            opacity: 1;
        }

        /* ======= RODAPÉ ======= */
        .footer {
            background-color: var(--preto);
            color: var(--cinza-claro);
            padding: 60px 20px 30px;
            font-size: 14px;
        }

        .footer h3 {
            color: var(--branco);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer p {
            color: var(--cinza-medio);
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: var(--cinza-medio);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer ul li a:hover {
            color: red;
        }

        .footer .app-logo img {
            width: 120px;
            margin-right: 10px;
            margin-top: 10px;
        }

        .footer .marca_empresa {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .footer .logo a {
            text-decoration: none;
        }

        .footer hr {
            border: none;
            height: 1px;
            background: #444;
            margin: 40px 0 20px;
        }

        .footer .Copyright {
            text-align: center;
            color: #777;
            font-size: 13px;
        }
    </style>


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


    <div class="products py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">✨ Produtos em Destaque</h2>
            </div>

            <div class="row justify-content-center">
                <!-- Card de Produto Exemplo -->
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-lg border-0 rounded-4 p-2 produto-card" data-nome="👗 Vestido"
                        data-preco="9500" data-categoria="Moda" data-estoque="8"
                        data-imagem="./img/img.carde/istockphoto-487770577-1024x1024.jpg">
                        <img src="./img/img.carde/istockphoto-487770577-1024x1024.jpg" class="card-img-top rounded-3"
                            alt="Vestido">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">👗 Vestido</h5>
                            <p class="text-muted mb-1">💰 9.500 kz</p>
                            <span class="badge bg-info mb-2">Categoria: Moda</span>
                            <button class="btn btn-warning w-100 produto-btn" data-bs-toggle="modal"
                                data-bs-target="#produtoModal">🛒 Ver Detalhes</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-lg border-0 rounded-4 p-2 produto-card" data-nome="👗 Vestido"
                        data-preco="9500" data-categoria="Moda" data-estoque="8"
                        data-imagem="./img/img.carde/istockphoto-487770577-1024x1024.jpg">
                        <img src="./img/img.carde/istockphoto-487770577-1024x1024.jpg" class="card-img-top rounded-3"
                            alt="Vestido">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">👗 Vestido</h5>
                            <p class="text-muted mb-1">💰 9.500 kz</p>
                            <span class="badge bg-info mb-2">Categoria: Moda</span>
                            <button class="btn btn-warning w-100 produto-btn" data-bs-toggle="modal"
                                data-bs-target="#produtoModal">🛒 Ver Detalhes</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-lg border-0 rounded-4 p-2 produto-card" data-nome="👗 Vestido"
                        data-preco="9500" data-categoria="Moda" data-estoque="8"
                        data-imagem="./img/img.carde/istockphoto-487770577-1024x1024.jpg">
                        <img src="./img/img.carde/istockphoto-487770577-1024x1024.jpg" class="card-img-top rounded-3"
                            alt="Vestido">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">👗 Vestido</h5>
                            <p class="text-muted mb-1">💰 9.500 kz</p>
                            <span class="badge bg-info mb-2">Categoria: Moda</span>
                            <button class="btn btn-warning w-100 produto-btn" data-bs-toggle="modal"
                                data-bs-target="#produtoModal">🛒 Ver Detalhes</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-lg border-0 rounded-4 p-2 produto-card" data-nome="👗 Vestido"
                        data-preco="9500" data-categoria="Moda" data-estoque="8"
                        data-imagem="./img/img.carde/istockphoto-487770577-1024x1024.jpg">
                        <img src="./img/img.carde/istockphoto-487770577-1024x1024.jpg" class="card-img-top rounded-3"
                            alt="Vestido">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">👗 Vestido</h5>
                            <p class="text-muted mb-1">💰 9.500 kz</p>
                            <span class="badge bg-info mb-2">Categoria: Moda</span>
                            <button class="btn btn-warning w-100 produto-btn" data-bs-toggle="modal"
                                data-bs-target="#produtoModal">🛒 Ver Detalhes</button>
                        </div>
                    </div>
                </div>
                <!-- Repita o card para outros produtos -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="produtoModalLabel">Detalhes do Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <img id="produtoImagem" src="" class="img-fluid rounded-3" alt="Imagem do Produto">
                    </div>
                    <div class="col-md-6">
                        <h4 id="produtoNome"></h4>
                        <p class="text-muted">💰 <span id="produtoPreco"></span> kz</p>
                        <p id="produtoCategoria"></p>
                        <p>📦 Em estoque: <span id="produtoEstoque"></span> unidades</p>

                        <form id="formCompra">
                            <div class="mb-2">
                                <label class="form-label">Quantidade desejada</label>
                                <input type="number" id="quantidade" class="form-control" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total estimado</label>
                                <input type="text" id="totalEstimado" class="form-control" readonly>
                            </div>
                            <button type="submit" class="btn btn-success w-100">✅ Adicionar ao Carrinho</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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


    </script>
    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Exemplo de formulário com dados de produto -->
<form id="formCompra">
    <input type="hidden" name="produto_id" value="1">
    <input type="hidden" name="nome" id="produtoNome" value="Produto X">
    <input type="hidden" name="preco" id="produtoPreco" value="150">
    <input type="hidden" name="quantidade" id="quantidade" value="2">
    <button type="submit" class="btn btn-adicionar">Adicionar ao Carrinho</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        const produtoBtns = $(".produto-btn");
        const modalImagem = $("#produtoImagem");
        const modalNome = $("#produtoNome");
        const modalPreco = $("#produtoPreco");
        const modalCategoria = $("#produtoCategoria");
        const modalEstoque = $("#produtoEstoque");
        const inputQuantidade = $("#quantidade");
        const inputTotal = $("#totalEstimado");

        let precoUnitario = 0;
        let estoqueAtual = 0;

        produtoBtns.on("click", function () {
            const card = $(this).closest(".produto-card");

            const nome = card.data("nome");
            const preco = parseFloat(card.data("preco"));
            const categoria = card.data("categoria");
            const imagem = card.data("imagem");
            const estoque = parseInt(card.data("estoque"));

            precoUnitario = preco;
            estoqueAtual = estoque;

            modalImagem.attr("src", imagem);
            modalNome.text(nome);
            modalPreco.text(preco.toLocaleString());
            modalCategoria.text(`📂 Categoria: ${categoria}`);
            modalEstoque.text(estoque);

            inputQuantidade.val("");
            inputTotal.val("");
        });

        inputQuantidade.on("input", function () {
            const qtd = parseInt(inputQuantidade.val());
            if (!isNaN(qtd) && qtd > 0 && qtd <= estoqueAtual) {
                const total = qtd * precoUnitario;
                inputTotal.val(`${total.toLocaleString()} kz`);
            } else {
                inputTotal.val("Quantidade inválida");
            }
        });

        $("#formCompra").on("submit", function (e) {
            e.preventDefault();

            const nomeProduto = modalNome.text();
            const precoProduto = precoUnitario;
            const quantidadeProduto = parseInt(inputQuantidade.val());

            if (quantidadeProduto > 0) {
                // Usando AJAX com jQuery
                $.ajax({
                    url: "", // Envia para a mesma página
                    method: "GET", // Pode usar POST se necessário
                    data: {
                        nome: nomeProduto,
                        preco: precoProduto,
                        quantidade: quantidadeProduto
                    },
                    success: function (response) {
                        alert("✅ Produto adicionado ao carrinho!");
                        location.reload(); // Volta para a mesma página
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro:", error);
                        alert("❌ Erro ao adicionar ao carrinho.");
                    }
                });
            } else {
                alert("Quantidade inválida.");
            }
        });
    });
</script>



</body>

</html>