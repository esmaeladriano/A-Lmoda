<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce - Blusas de Diferentes Marcas</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.css" />
    <link rel="stylesheet" href="./assets/css/main.css" />
    <link rel="stylesheet" href="./assets/css/blusa.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .one-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            margin: 10px;
            width: 100%;
            max-width: 300px;
        }

        .one-card:hover {
            transform: translateY(-5px);
        }

        .photo img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        .content {
            padding: 20px;
        }

        .content .title {
            font-size: 1.2rem;
            color: #333;
        }

        .content .desc {
            font-size: 0.95rem;
            color: #777;
            margin: 10px 0;
        }

        .content .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #28a745;
        }

        .content .btn {
            background-color: #ffc107;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .content .btn:hover {
            background-color: #e0aa06;
        }

        .content .cart {
            font-size: 1.25rem;
            margin-right: 10px;
        }

        .content .review {
            font-size: 0.9rem;
            color: #555;
        }

        .content svg {
            width: 16px;
            height: 15px;
            margin-left: 5px;
            vertical-align: middle;
        }

        .desc span {
            display: block;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php include_once('./navbar.php') ?>

    <div class="container">
        <div class="row">
            <!-- Blusa 1 - Marca A -->
            <div class="col-md-4 mb-4">
                <div class="one-card">
                    <div class="photo">
                        <img src="./img/blusas/marcaA_blusa.jpg" alt="Blusa Marca A" />
                    </div>
                    <div class="content">
                        <span class="title fw-bold">Blusa Marca A</span>
                        <div class="desc">
                            <span>Material: Algodão 100%</span>
                            <span>Cor: Azul Claro</span>
                            <span>Tamanhos: P, M, G</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">1.200,00 KZ</span>
                            <span class="review">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.25" d="M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z" fill="black" />
                                </svg>
                                (25)
                            </span>
                        </div>

                        <button class="btn" data-toggle="modal" data-target="#exampleModal">
                            <i class="cart"></i><b>Adicionar ao Carrinho 🛒</b>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Blusa 2 - Marca B -->
            <div class="col-md-4 mb-4">
                <div class="one-card">
                    <div class="photo">
                        <img src="./img/blusas/marcaB_blusa.jpg" alt="Blusa Marca B" />
                    </div>
                    <div class="content">
                        <span class="title fw-bold">Blusa Marca B</span>
                        <div class="desc">
                            <span>Material: Poliéster</span>
                            <span>Cor: Preto</span>
                            <span>Tamanhos: P, M, G, GG</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">1.500,00 KZ</span>
                            <span class="review">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.25" d="M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z" fill="black" />
                                </svg>
                                (40)
                            </span>
                        </div>

                        <button class="btn" data-toggle="modal" data-target="#exampleModal">
                            <i class="cart"></i><b>Adicionar ao Carrinho 🛒</b>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Blusa 3 - Marca C -->
            <div class="col-md-4 mb-4">
                <div class="one-card">
                    <div class="photo">
                        <img src="./img/blusas/marcaC_blusa.jpg" alt="Blusa Marca C" />
                    </div>
                    <div class="content">
                        <span class="title fw-bold">Blusa Marca C</span>
                        <div class="desc">
                            <span>Material: Seda</span>
                            <span>Cor: Vermelha</span>
                            <span>Tamanhos: M, G</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price">2.000,00 KZ</span>
                            <span class="review">
                                <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.25" d="M14.673 7.17173C15.7437 6.36184 15.1709 4.65517 13.8284 4.65517H11.3992C10.7853 4.65517 10.243 4.25521 10.0617 3.66868L9.33754 1.32637C8.9309 0.0110567 7.0691 0.0110564 6.66246 1.32637L5.93832 3.66868C5.75699 4.25521 5.21469 4.65517 4.60078 4.65517H2.12961C0.791419 4.65517 0.215919 6.35274 1.27822 7.16654L3.39469 8.78792C3.85885 9.1435 4.05314 9.75008 3.88196 10.3092L3.11296 12.8207C2.71416 14.1232 4.22167 15.1704 5.30301 14.342L7.14861 12.9281C7.65097 12.5432 8.34903 12.5432 8.85139 12.9281L10.6807 14.3295C11.7636 15.159 13.2725 14.1079 12.8696 12.8046L12.09 10.2827C11.9159 9.71975 12.113 9.10809 12.5829 8.75263L14.673 7.17173Z" fill="black" />
                                </svg>
                                (30)
                            </span>
                        </div>

                        <button class="btn" data-toggle="modal" data-target="#exampleModal">
                            <i class="cart"></i><b>Adicionar ao Carrinho 🛒</b>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal de Adicionar ao Carrinho -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Produto Adicionado ao Carrinho!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Seu item foi adicionado ao carrinho. Deseja continuar comprando ou finalizar a compra?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/bootstrap.bundle.js"></script>
</body>

</html>
