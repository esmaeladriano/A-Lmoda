<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "adicionar") {
    $id_usuario = $_SESSION['usuario_id'];
    $id_produto = intval($_POST["id_produto"]);
    $quantidade = intval($_POST["quantidade"]);

    $stmt = $conn->prepare("INSERT INTO carrinho (id_usuario, id_produto, quantidade, data_adicionado) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iii", $id_usuario, $id_produto, $quantidade);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => $conn->error]);
    }
    exit;
}
$produtos = $conn->query("SELECT p.id, p.nome, p.descricao, p.preco, p.imagem, c.nome AS categoria FROM produtos p 
JOIN categorias c ON p.categoria_id = c.id 
WHERE c.nome = 'sapato'
ORDER BY p.data_adicao DESC");

$lista_produtos = [];
while($p = $produtos->fetch_assoc()) {
    $lista_produtos[] = $p;
}
?>



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

    <?php include_once('./navbar_categoria.php') ?>

    <div class="container py-5">
    <div class="row">
        <?php foreach ($lista_produtos as $p): ?>
        <div class="col-md-3 mb-4">
            <div class="card shadow border-0 h-100" style="transition: transform 0.3s ease; border-radius: 20px;">
                <img src="http://localhost/A&Lmoda/painel/admin/uploads/<?= $p['imagem'] ?>" 
                    class="card-img-top img-fluid rounded-top" 
                    style="height: 247px; object-fit: cover;" 
                    alt="<?= $p['nome'] ?>">
                <div class="card-body bg-light">
                    <h5 class="card-title text-primary fw-bold"><?= $p['nome'] ?> ✨</h5>
                    <p class="card-text text-muted small"><?= mb_strimwidth($p['descricao'], 0, 100, "...") ?></p>
                    <p class="mb-1">
                        <span class="badge bg-success">💰 <?= number_format($p['preco'], 2, ',', '.') ?> Kz</span>
                    </p>
                    <p class="text-secondary">📁 <em><?= $p['categoria'] ?></em></p> 
                    <button 
                        class="btn btn-outline-primary btn-sm btn-adicionar w-100 fw-bold"
                        data-id="<?= $p['id'] ?>" 
                        data-nome="<?= $p['nome'] ?>" 
                        data-preco="<?= $p['preco'] ?>"
                        data-imagem="http://localhost/A&Lmoda/painel/admin/uploads/<?= $p['imagem'] ?>">
                        ➕ Adicionar ao Carrinho
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalCarrinho" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar ao Carrinho</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formCarrinho">
          <input type="hidden" id="produto_id">
          <p><strong id="produto_nome"></strong></p>
          <center>
          <img id="produto_imagem" src="" class="img-fluid rounded mb-3" style="max-width: 50%;">
          </center>
          
          <p>Preço unitário: <span id="produto_preco"></span> Kz</p>

          <div class="mb-3">
            <label>Quantidade</label>
            <input type="number" id="quantidade" class="form-control" min="1" value="1">
          </div>

          <div class="mb-3">
            <label>Total</label>
            <input type="text" id="total" class="form-control" readonly>
          </div>

          <button type="submit" class="btn btn-success w-100">✅ Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let precoUnitario = 0;

$(document).on('click', '.btn-adicionar', function () {
    const id = $(this).data('id');
    const nome = $(this).data('nome');
    const preco = $(this).data('preco');
    const imagem = $(this).data('imagem');

    $('#produto_id').val(id);
    $('#produto_nome').text(nome);
    $('#produto_preco').text(preco);
    $('#produto_imagem').attr('src', imagem);
    $('#quantidade').val(1);
    $('#total').val(preco + ' Kz');
    precoUnitario = parseFloat(preco);

    const modal = new bootstrap.Modal(document.getElementById('modalCarrinho'));
    modal.show();
});

$('#quantidade').on('input', function () {
    const qtd = parseInt($(this).val()) || 1;
    const total = qtd * precoUnitario;
    $('#total').val(total + ' Kz');
});

$('#formCarrinho').submit(function (e) {
    e.preventDefault();

    $.post('produtos.php', {
        acao: 'adicionar',
        id_produto: $('#produto_id').val(),
        quantidade: $('#quantidade').val()
    }, function (res) {
        console.log(res);
        const r = JSON.parse(res);
        if (r.status === 'sucesso') {
            alert('✅ Produto adicionado ao carrinho!');
            bootstrap.Modal.getInstance(document.getElementById('modalCarrinho')).hide();
        } else {
            alert('Erro: ' + r.mensagem);
        }
    });
});
</script>

</body>
</html>
