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
WHERE destaque = 1
ORDER BY p.data_adicao DESC
limit 4");

$lista_produtos = [];
while($p = $produtos->fetch_assoc()) {
    $lista_produtos[] = $p;
}
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
    <h2 class="text-center mb-4">🛍️ Produtos Em Destaque</h2>
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


<?php
if (isset($_SESSION['usuario_id'])) {?>
    <!-- MODAL -->
<!-- Modal Carrinho -->
<div class="modal fade" id="modalCarrinho" tabindex="-1" aria-hidden="true" aria-labelledby="modalCarrinhoLabel">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content shadow-lg p-3 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="modalCarrinhoLabel">Adicionar ao Carrinho</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center">
        <form id="formCarrinho" class="needs-validation" novalidate>
          <input type="hidden" id="produto_id">
          <p class="fs-5 text-truncate fw-semibold" id="produto_nome"></p>

          <img id="produto_imagem" src="" alt="Imagem do produto" class="img-fluid rounded mb-3" style="max-width: 60%; max-height: 150px; object-fit: contain;">

          <p class="mb-3"><strong>Preço unitário:</strong> <span id="produto_preco" class="text-success fs-5"></span> Kz</p>

          <div class="mb-3 text-start">
            <label for="quantidade" class="form-label fw-semibold">Quantidade</label>
            <input type="number" id="quantidade" class="form-control form-control-lg" min="1" value="1" required>
            <div class="invalid-feedback">Por favor, insira uma quantidade válida.</div>
          </div>

          <div class="mb-4 text-start">
            <label for="total" class="form-label fw-semibold">Total</label>
            <input type="text" id="total" class="form-control form-control-lg text-success fw-bold" readonly style="background-color: #e9f7ef;">
          </div>

          <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">✅ Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>
    <div class="alert alert-warning text-center">
        <strong>⚠️ Atenção!</strong> Você precisa estar logado para adicionar produtos ao carrinho.
        <a href="http://localhost/A&Lmoda/" class="btn btn-primary btn-sm">Fazer Login</a>
    </div>
<?php } ?>


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
            window.location.href="http://localhost/A&Lmoda/";

            bootstrap.Modal.getInstance(document.getElementById('modalCarrinho')).hide();
        } else {
            alert('Erro: ' + r.mensagem);
        }
    });
});
</script>

</body>
</html>
