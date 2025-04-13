<?php

include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
// Adicionar ao carrinho via AJAX
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["acao"]) && $_POST["acao"] === "adicionar") {
    $id_usuario = $_SESSION['usuario_id'];; // Trocar pelo ID real do usuário logado
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

// Buscar produtos
$produtos = $conn->query("SELECT p.id, p.nome, p.descricao, p.preco, p.imagem, c.nome AS categoria FROM produtos p JOIN categorias c ON p.categoria_id = c.id ORDER BY p.data_adicao DESC");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center mb-4">🛍️ Produtos Disponíveis</h2>
    <div class="row">
        <?php while($p = $produtos->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="<?= $p['imagem'] ?>" class="card-img-top" alt="<?= $p['nome'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $p['nome'] ?></h5>
                    <p class="card-text"><?= $p['descricao'] ?></p>
                    <p><strong>💰 <?= number_format($p['preco'], 2, ',', '.') ?> Kz</strong></p>
                    <p>📂 <?= $p['categoria'] ?></p>
                    <button 
                        class="btn btn-primary btn-adicionar" 
                        data-id="<?= $p['id'] ?>" 
                        data-nome="<?= $p['nome'] ?>" 
                        data-preco="<?= $p['preco'] ?>"
                        data-imagem="<?= $p['imagem'] ?>">
                        ➕ Adicionar ao Carrinho
                    </button>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
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
          <img id="produto_imagem" src="" class="img-fluid rounded mb-3" style="max-height: 200px;">
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
        const r = JSON.parse(res);
        console.log(r);
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
