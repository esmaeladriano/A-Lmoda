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
    echo "<div class='alert alert-warning text-center'>Você precisa estar logado para ver o carrinho.</div>";
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
    echo "<div class='alert alert-info text-center'>Seu carrinho está vazio!</div>";
} else {
    while ($row = $result->fetch_assoc()) {
        $produtos_no_carrinho[] = $row;
    }
}

// Função para remover produto do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'remover') {
    $id_produto = $_POST['id_produto'];
    echo("ID do usuário: " . $id_usuario . "<br>" . $id_produto);
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
        .product-info p, .product-price p {
            color: #333;
            font-size: 1rem;
        }
    </style>
</head>
<body class="p-4">

<div class="container"></div></div>
    <h3 class="animate__animated animate__fadeIn text-center mb-4">🛒 Seu Carrinho</h3>

    <?php if (!empty($produtos_no_carrinho)): ?>
        <div id="carrinho-container">
            <?php 
            $total = 0;
            foreach ($produtos_no_carrinho as $produto):
                $total += $produto['preco'] * $produto['quantidade'];
            
            ?>
            
            <div class="product-card animate__animated animate__fadeInUp" id="produto-<?= $produto['id'] ?>">
                <img src="<?= 'http://localhost/A&Lmoda/painel/admin/uploads/'.$produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                <div class="product-info">
                    <h5><?= $produto['nome'] ?></h5>
                    <p>Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                    <div class="d-flex align-items-center">
                        <input type="number" value="<?= $produto['quantidade'] ?>" class="form-control quantity-input" data-produto-id="<?= $produto['id'] ?>" onchange="atualizarQuantidade(<?= $produto['id'] ?>)">
                        <button class="btn btn-danger btn-sm ms-2" onclick="removerDoCarrinho(<?= $produto['id_produto'] ?>)">🗑</button>
                    </div>
                </div>
                <div class="product-price">
                    <p>Subtotal: R$ <span class="subtotal" id="subtotal-<?= $produto['id'] ?>"><?= number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.') ?></span></p>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="total-price text-end mt-3">
                Total: R$ <span id="total-price"><?= number_format($total, 2, ',', '.') ?></span>
            </div>

            <div class="text-end">
                <a href="efetuar_pedido.php" class="btn btn-success btn-finalizar mt-3">🧾 Efetuar Pedido</a>
            </div>
        </div>
    <?php endif; ?>
</div>

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
        document.querySelectorAll('.subtotal').forEach(function(subtotal) {
            total += parseFloat(subtotal.textContent.replace(',', '.'));
        });
        document.getElementById('total-price').textContent = total.toFixed(2).replace('.', ',');
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
