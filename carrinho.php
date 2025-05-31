<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Conectar com o banco de dados
include_once('./conexao.php');

if (!$conn) {
    die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
}

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "
    <script>
        alert('Você precisa estar logado para ver o carrinho.');
        window.location.href = 'index.php';
    </script>
    ";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];



// Obter os itens no carrinho do usuário
$query = "SELECT c.id, c.id_produto, c.quantidade, p.nome, p.preco, p.imagem 
          FROM carrinho c 
          JOIN produtos p ON c.id_produto = p.id
          WHERE c.id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se o carrinho está vazio
$produtos_no_carrinho = [];
if ($result->num_rows === 0) {
    echo "";
} else {
    while ($row = $result->fetch_assoc()) {
        $produtos_no_carrinho[] = $row;
    }
}

// Função para remover produto do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'remover') {
    $id_produto = $_POST['id_produto'];
    echo ("ID do usuário: " . $id_usuario . "<br>" . $id_produto);
    $stmt = $conn->prepare("DELETE FROM carrinho WHERE id_usuario = ? AND id_produto = ?");
    $stmt->bind_param("ii", $id_usuario, $id_produto);
    $stmt->execute();
    echo 'Produto removido com sucesso!';
    exit;
}

// Função para atualizar a quantidade do produto no carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'atualizar') {
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];
    $stmt = $conn->prepare("UPDATE carrinho SET quantidade = ? WHERE id_usuario = ? AND id_produto = ?");
    $stmt->bind_param("iii", $quantidade, $id_usuario, $id_produto);
    $stmt->execute();
    echo 'Quantidade atualizada com sucesso!';
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .product-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-info h5 {
            margin: 0;
            font-size: 1.2rem;
        }

        .quantity-input {
            width: 60px;
        }

        .total-price {
            font-weight: bold;
            font-size: 1.5rem;
            color: #28a745;
        }

        .btn-finalizar {
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-finalizar:hover {
            background-color: #218838;
        }

        .product-info p,
        .product-price p {
            color: #333;
            font-size: 1rem;
        }
    </style>
</head>

<body class="p-4">

    <div class="container py-4" style="max-width: 900px;">
        <ul class="nav nav-tabs mb-4" id="carrinhoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="carrinho-tab" data-bs-toggle="tab" data-bs-target="#carrinho"
                    type="button" role="tab" aria-controls="carrinho" aria-selected="true">
                    🛒 Seu Carrinho
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pedidos-tab" data-bs-toggle="tab" data-bs-target="#pedidos" type="button"
                    role="tab" aria-controls="pedidos" aria-selected="false">
                    📦 Meus Pedidos
                </button>
            </li>
        </ul>
        <div class="tab-content" id="carrinhoTabsContent">
            <div class="tab-pane fade show active" id="carrinho" role="tabpanel" aria-labelledby="carrinho-tab">
                <!-- Conteúdo do carrinho (já existente abaixo) -->
                <div class="text-center mb-4">
                    <a href="index.php" class="btn btn-primary"
                        style="background: linear-gradient(90deg, #6a89cc 0%, #b8e994 100%); border: none;">
                        Voltar às Compras
                    </a>
                </div>


                <?php if (!empty($produtos_no_carrinho)): ?>
                    <?php
                    // Agrupar produtos pelo nome e preço
                    $produtos_agrupados = [];
                    foreach ($produtos_no_carrinho as $produto) {
                        $chave = $produto['nome'] . '|' . $produto['preco'];
                        if (!isset($produtos_agrupados[$chave])) {
                            $produtos_agrupados[$chave] = $produto;
                        } else {
                            $produtos_agrupados[$chave]['quantidade'] += $produto['quantidade'];
                        }
                    }
                    $total = 0;
                    ?>

                    <div class="table-responsive animate__animated animate__fadeInUp">
                        <table class="table table-bordered align-middle shadow"
                            style="background: #fff; border-radius: 12px; overflow: hidden;">
                            <thead style="background: linear-gradient(90deg, #6a89cc 0%, #b8e994 100%); color: #222;">
                                <tr>
                                    <th style="width: 110px;">Imagem</th>
                                    <th>Produto</th>
                                    <th>Preço Unitário</th>
                                    <th>Quantidade</th>
                                    <th>Subtotal</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos_agrupados as $produto):
                                    $subtotal = $produto['preco'] * $produto['quantidade'];
                                    $total += $subtotal;
                                    ?>
                                    <tr id="produto-<?= $produto['id_produto'] ?>" style="vertical-align: middle;">
                                        <td>
                                            <img src="<?= 'http://localhost/A&Lmoda/painel/admin/uploads/' . $produto['imagem'] ?>"
                                                alt="<?= htmlspecialchars($produto['nome']) ?>" class="img-thumbnail"
                                                style="width: 90px; height: 90px; object-fit: cover; border-radius: 8px; background: #f1f2f6;">
                                        </td>
                                        <td>
                                            <span
                                                style="font-weight: 600; color: #0984e3;"><?= htmlspecialchars($produto['nome']) ?></span>
                                        </td>
                                        <td>
                                            <span style="color: #00b894; font-weight: 500;">
                                                KZ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="1" value="<?= $produto['quantidade'] ?>"
                                                class="form-control quantity-input text-center"
                                                data-produto-id="<?= $produto['id_produto'] ?>"
                                                style="width: 70px; border: 1.5px solid #b2bec3;"
                                                onchange="atualizarQuantidade(<?= $produto['id_produto'] ?>)">
                                        </td>
                                        <td>
                                            <span class="subtotal" id="subtotal-<?= $produto['id_produto'] ?>"
                                                style="color: #fdcb6e; font-weight: bold;">
                                                <?= number_format($subtotal, 2, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                                style="background: linear-gradient(90deg, #ff7675 0%, #d63031 100%); border: none;"
                                                onclick="removerDoCarrinho(<?= $produto['id_produto'] ?>)">
                                                🗑 Remover
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"
                                        style="font-size: 1.2rem; font-weight: 600; color: #636e72;">
                                        Total:
                                    </td>
                                    <td colspan="2" class="total-price"
                                        style="font-size: 1.5rem; color: #00b894; font-weight: bold;">
                                        KZ <span id="total-price"><?= number_format($total, 2, ',', '.') ?></span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <a href="efetuar_pedido.php" class="btn btn-success btn-lg btn-finalizar shadow"
                            style="background: linear-gradient(90deg, #00b894 0%, #00cec9 100%); border: none;">
                            🧾 Efetuar Pedido
                        </a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center animate__animated animate__fadeInDown"
                        style="font-size: 1.2rem;">
                        Seu carrinho está vazio!
                    </div>
                <?php endif; ?>
            </div>
        </div>



        <div class="tab-pane fade" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
            <div class="text-center mb-4">
                <h3>Meus Pedidos</h3>

            </div>
            <div class="text-center mb-4">
                <a href="index.php" class="btn btn-primary"
                    style="background: linear-gradient(90deg, #6a89cc 0%, #b8e994 100%); border: none;">
                    Voltar às Compras
                </a>
            </div>
            <!-- Aqui você pode adicionar o conteúdo dos pedidos do usuário -->
            <?php
            // Cancelar pedido
            if (isset($_GET['cancelar']) && is_numeric($_GET['cancelar'])) {
                $pedido_id = $_GET['cancelar'];

                // Verifica se é do usuário e está pendente
                $sql = "SELECT * FROM pedidos WHERE id = ? AND id_usuario = ? AND status = 'pendente'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $pedido_id, $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows) {
                    $sql = "UPDATE pedidos SET status = 'cancelado' WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $pedido_id);
                    $stmt->execute();
                    echo "
            <script>alert('Pedido cancelado com sucesso!'); window.location = 'meus_pedidos.php';</script>";
                    exit;
                }
            }

            // Listar pedidos
            $sql = "SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY data_pedido DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive animate__animated animate__fadeInUp">
                    <table class="table table-bordered align-middle shadow"
                        style="background: #fff; border-radius: 12px; overflow: hidden;">
                        <thead style="background: linear-gradient(90deg, #6a89cc 0%, #b8e994 100%); color: #222;">
                            <tr>
                                <th style="width: 120px;">Pedido</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($pedido = $result->fetch_assoc()): ?>
                                <tr style="vertical-align: middle;">
                                    <td>
                                        <span style="font-weight: 600; color: #0984e3;">#<?= $pedido['id'] ?></span>
                                    </td>
                                    <td>
                                        <span style="color: #636e72;">
                                            <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-weight: 500; color: 
                                            <?php
                                            switch ($pedido['status']) {
                                                case 'pendente':
                                                    echo '#fdcb6e';
                                                    break;
                                                case 'cancelado':
                                                    echo '#d63031';
                                                    break;
                                                case 'concluido':
                                                    echo '#00b894';
                                                    break;
                                                default:
                                                    echo '#636e72';
                                            }
                                            ?>">
                                            <?= ucfirst($pedido['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="color: #00b894; font-weight: bold;">
                                            KZ <?= number_format($pedido['total'], 2, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        switch ($pedido['status']) {
                                            case 'pendente':
                                                ?>
                                                <a href="meus_pedidos.php?cancelar=<?= $pedido['id'] ?>" class="btn btn-danger btn-sm"
                                                    style="background: linear-gradient(90deg, #ff7675 0%, #d63031 100%); border: none;"
                                                    onclick="return confirm('Você tem certeza que deseja cancelar este pedido?')">
                                                    🗑 Cancelar
                                                </a>
                                                <?php
                                                break;
                                            default:
                                                ?>
                                                <span class="text-muted">-</span>
                                                <?php
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center animate__animated animate__fadeInDown" style="font-size: 1.2rem;">
                    Você ainda não fez nenhum pedido!
                </div>
            <?php endif; ?>

            <script>
                function removerDoCarrinho(id_produto) {
                    if (confirm("Você tem certeza que deseja remover este produto do carrinho?")) {
                        fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=remover&id_produto=${id_produto}`
                        }).then(response => response.text())
                            .then(response => {
                                alert(response);
                                location.reload();
                            });
                    }
                }

                function atualizarQuantidade(id_produto) {
                    let quantidade = document.querySelector(`[data-produto-id='${id_produto}']`).value;

                    fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=atualizar&id_produto=${id_produto}&quantidade=${quantidade}`
                    }).then(response => response.text())
                        .then(response => {
                            alert(response);
                            let preco = parseFloat(document.querySelector(`#produto-${id_produto} .product-info p`).textContent.replace('Preço: R$ ', '').replace(',', '.'));
                            let subtotal = preco * quantidade;
                            document.querySelector(`#subtotal-${id_produto}`).textContent = subtotal.toFixed(2).replace('.', ',');
                            atualizarTotal();
                        });
                }

                function atualizarTotal() {
                    let total = 0;
                    document.querySelectorAll('.subtotal').forEach(function (subtotal) {
                        total += parseFloat(subtotal.textContent.replace(',', '.'));
                    });
                    document.getElementById('total-price').textContent = total.toFixed(2).replace('.', ',');
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>