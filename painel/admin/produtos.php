<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();

// CADASTRAR PRODUTO
if (isset($_POST['add_produto'])) {
  $nome = trim($_POST['nome']);
  $descricao = trim($_POST['descricao']);
  $preco = $_POST['preco'];
  $categoria_id = $_POST['categoria_id'];
  $destaque = isset($_POST['destaque']) ? 1 : 0;
  $imagem_nome = '';

  // Verificar se o produto já existe
  //$verifica = $conn->prepare("SELECT id FROM produtos_baner WHERE nome = ?");
  //$verifica->bind_param("s", $nome);
  //$verifica->execute();
  //$verifica->store_result();

  //if ($verifica->num_rows > 0) {
  //echo "<script>alert('❗ Produto já existe, com esse nome!'); window.location.////href='produtos.php';</script>";
  //exit;
  // }

  // Upload da imagem
  // Verificar se uma imagem foi enviada
  if ($_FILES['imagem']['error'] == 0) {
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $max_size = 10 * 1024 * 1024; // 10MB

    if (!in_array($ext, $allowed_ext)) {
      echo "<script>alert('❗ Apenas arquivos JPG, JPEG ou PNG são permitidos.'); window.location.href='produtos.php';</script>";
      exit;
    }

    if ($_FILES['imagem']['size'] > $max_size) {
      echo "<script>alert('❗ O tamanho máximo da imagem é 10MB.'); window.location.href='produtos.php';</script>";
      exit;
    }

    $imagem_nome = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['imagem']['tmp_name'], "uploads/" . $imagem_nome);
  }

  // Inserir no banco de dados
  $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, categoria_id, imagem, destaque) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdisi", $nome, $descricao, $preco, $categoria_id, $imagem_nome, $destaque);
  $stmt->execute();

  echo "<script>alert('✅ Produto adicionado com sucesso!'); window.location.href='produtos.php';</script>";
}



// CADASTRAR PRODUTO_Destaque
if (isset($_POST['add_baner'])) {
  $nome = trim($_POST['nome']);
  $descricao = trim($_POST['descricao']);
  $preco = $_POST['preco'];
  $categoria_id = $_POST['categoria_id'];
  $imagem_nome = '';

  // Verificar se o produto já existe
  //$verifica = $conn->prepare("SELECT id FROM produtos_baner WHERE nome = ?");
  //$verifica->bind_param("s", $nome);
  //$verifica->execute();
  //$verifica->store_result();

  //if ($verifica->num_rows > 0) {
  //echo "<script>alert('❗ Produto já existe, com esse nome!'); window.location.////href='produtos.php';</script>";
  //exit;
  // }

  // Upload da imagem
  // Verificar se uma imagem foi enviada
  if ($_FILES['imagem']['error'] == 0) {
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $max_size = 10 * 1024 * 1024; // 10MB

    if (!in_array($ext, $allowed_ext)) {
      echo "<script>alert('❗ Apenas arquivos JPG, JPEG ou PNG são permitidos.'); window.location.href='produtos.php';</script>";
      exit;
    }

    if ($_FILES['imagem']['size'] > $max_size) {
      echo "<script>alert('❗ O tamanho máximo da imagem é 10MB.'); window.location.href='produtos.php';</script>";
      exit;
    }

    $imagem_nome = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['imagem']['tmp_name'], "uploads/" . $imagem_nome);
  }

  // Inserir no banco de dados
  $stmt = $conn->prepare("INSERT INTO produtos_baner (nome, descricao, preco, categoria_id, imagem) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdis", $nome, $descricao, $preco, $categoria_id, $imagem_nome);
  $stmt->execute();

  echo "<script>alert('✅ Produto adicionado com sucesso!'); window.location.href='produtos.php';</script>";
}

// EDITAR PRODUTO
if (isset($_POST['edit_produto'])) {
  $id = $_POST['id'];
  $nome = trim($_POST['nome']);
  $descricao = trim($_POST['descricao']);
  $preco = $_POST['preco'];
  $categoria_id = $_POST['categoria_id'];
  $destaque = isset($_POST['destaque']) ? 1 : 0;
  $imagem_nome = $_POST['imagem_atual'];  // Manter a imagem atual, caso não altere

  // Verificar se uma nova imagem foi enviada
  if ($_FILES['imagem']['error'] == 0) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['imagem']['tmp_name'], "uploads/" . $imagem_nome);
  }

  // Atualizar produto no banco
  $stmt = $conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, categoria_id=?, imagem=?, destaque=? WHERE id=?");
  $stmt->bind_param("ssdisii", $nome, $descricao, $preco, $categoria_id, $imagem_nome, $destaque, $id);
  $stmt->execute();

  echo "<script>alert('✅ Produto atualizado com sucesso!'); window.location.href='produtos.php';</script>";
}

// EXCLUIR PRODUTO
if (isset($_POST['delete_produto'])) {
  $id = $_POST['id'];
  $conn->query("DELETE FROM produtos WHERE id=$id");
  echo "<script>alert('🗑 Produto excluído.'); window.location.href='produtos.php';</script>";
}

// LISTAR PRODUTOS
$categorias1 = $conn->query("SELECT * FROM categorias ORDER BY nome ASC limit 10");


$categorias = $conn->query("SELECT * FROM categorias ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Produtos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include_once('./navbar.php'); ?>
  <div class="main-content" style="margin-top: 56px;">
    <div class="d-flex justify-content-between mb-3">
      <h3><i class="fas fa-box"></i> Produtos</h3>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProdutoBanner">+ Produto
        Banner</button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProduto">+ Novo Produto</button>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-3" id="produtosTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="produtos-tab" data-bs-toggle="tab" data-bs-target="#produtos" type="button"
          role="tab">Produtos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="baner-tab" data-bs-toggle="tab" data-bs-target="#baner" type="button"
          role="tab">Produtos Banner</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="destaque-tab" data-bs-toggle="tab" data-bs-target="#destaque" type="button"
          role="tab">Produtos em Destaque</button>
      </li>
    </ul>

    <div class="tab-content" id="produtosTabContent">
      <!-- Produtos Tab -->
      <div class="tab-pane fade show active" id="produtos" role="tabpanel">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Preço</th>
              <th>Categoria</th>
              <th>Imagem</th>
              <th>Destaque</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Paginação Produtos
            $pagina = isset($_GET['pagina_produtos']) ? (int) $_GET['pagina_produtos'] : 1;
            $limite = 6;
            $offset = ($pagina - 1) * $limite;
            $totalProdutos = $conn->query("SELECT COUNT(*) as total FROM produtos")->fetch_assoc()['total'];
            $totalPaginas = ceil($totalProdutos / $limite);
            $produtosPaginados = $conn->query("SELECT p.*, c.nome AS categoria_nome FROM produtos p JOIN categorias c ON p.categoria_id = c.id ORDER BY p.data_adicao DESC LIMIT $offset, $limite");
            while ($produto = $produtosPaginados->fetch_assoc()):
              ?>
              <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['descricao'] ?></td>
                <td>KZ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td><?= $produto['categoria_nome'] ?></td>
                <td>
                  <?php if ($produto['imagem']): ?>
                    <img src="uploads/<?= $produto['imagem'] ?>" alt="Imagem" width="50">
                  <?php else: ?>
                    <em>Sem imagem</em>
                  <?php endif; ?>
                </td>
                <td><?= $produto['destaque'] ? 'Sim' : 'Não' ?></td>
                <td>
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditProduto"
                    onclick="editarProduto(<?= $produto['id'] ?>)">Editar</button>
                  <form method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                    <button type="submit" name="delete_produto" class="btn btn-sm btn-danger"
                      onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php if ($totalPaginas > 1): ?>
          <nav>
            <ul class="pagination">
              <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                  <a class="page-link" href="?pagina_produtos=<?= $i ?>#produtos"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>

      <!-- Produtos Banner Tab -->
      <div class="tab-pane fade" id="baner" role="tabpanel">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Preço</th>
              <th>Categoria</th>
              <th>Imagem</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Paginação Produtos Banner
            $pagina1 = isset($_GET['pagina_baner']) ? (int) $_GET['pagina_baner'] : 1;
            $limite1 = 4;
            $offset1 = ($pagina1 - 1) * $limite1;
            $totalProdutos1 = $conn->query("SELECT COUNT(*) as total FROM produtos_baner")->fetch_assoc()['total'];
            $totalPaginas1 = ceil($totalProdutos1 / $limite1);
            $produtos1Paginados = $conn->query("SELECT p.*, c.nome AS categoria_nome FROM produtos_baner p JOIN categorias c ON p.categoria_id = c.id ORDER BY p.data_adicao DESC LIMIT $offset1, $limite1");
            while ($produto = $produtos1Paginados->fetch_assoc()):
              ?>
              <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['descricao'] ?></td>
                <td>KZ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td><?= $produto['categoria_nome'] ?></td>
                <td>
                  <?php if ($produto['imagem']): ?>
                    <img src="uploads/<?= $produto['imagem'] ?>" alt="Imagem" width="50">
                  <?php else: ?>
                    <em>Sem imagem</em>
                  <?php endif; ?>
                </td>
                <td>
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalProdutoBanner"
                    onclick="editarProduto(<?= $produto['id'] ?>)">Editar</button>
                  <form method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                    <button type="submit" name="delete_produto" class="btn btn-sm btn-danger"
                      onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php if ($totalPaginas1 > 1): ?>
          <nav>
            <ul class="pagination">
              <?php for ($i = 1; $i <= $totalPaginas1; $i++): ?>
                <li class="page-item <?= $i == $pagina1 ? 'active' : '' ?>">
                  <a class="page-link" href="?pagina_baner=<?= $i ?>#baner"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>

      <!-- Produtos em Destaque Tab -->
      <div class="tab-pane fade" id="destaque" role="tabpanel">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Preço</th>
              <th>Categoria</th>
              <th>Imagem</th>
              <th>Destaque</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Paginação Produtos em Destaque
            $paginaDestaque = isset($_GET['pagina_destaque']) ? (int) $_GET['pagina_destaque'] : 1;
            $limiteDestaque = 6;
            $offsetDestaque = ($paginaDestaque - 1) * $limiteDestaque;
            $totalDestaque = $conn->query("SELECT COUNT(*) as total FROM produtos WHERE destaque=1")->fetch_assoc()['total'];
            $totalPaginasDestaque = ceil($totalDestaque / $limiteDestaque);
            $produtosDestaque = $conn->query("SELECT p.*, c.nome AS categoria_nome FROM produtos p JOIN categorias c ON p.categoria_id = c.id WHERE p.destaque=1 ORDER BY p.data_adicao DESC LIMIT $offsetDestaque, $limiteDestaque");
            while ($produto = $produtosDestaque->fetch_assoc()):
              ?>
              <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['nome'] ?></td>
                <td><?= $produto['descricao'] ?></td>
                <td>KZ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td><?= $produto['categoria_nome'] ?></td>
                <td>
                  <?php if ($produto['imagem']): ?>
                    <img src="uploads/<?= $produto['imagem'] ?>" alt="Imagem" width="50">
                  <?php else: ?>
                    <em>Sem imagem</em>
                  <?php endif; ?>
                </td>
                <td><?= $produto['destaque'] ? 'Sim' : 'Não' ?></td>
                <td>
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditProduto"
                    onclick="editarProduto(<?= $produto['id'] ?>)">Editar</button>
                  <form method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                    <button type="submit" name="delete_produto" class="btn btn-sm btn-danger"
                      onclick="return confirm('Deseja excluir este produto?')">Excluir</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <?php if ($totalPaginasDestaque > 1): ?>
          <nav>
            <ul class="pagination">
              <?php for ($i = 1; $i <= $totalPaginasDestaque; $i++): ?>
                <li class="page-item <?= $i == $paginaDestaque ? 'active' : '' ?>">
                  <a class="page-link" href="?pagina_destaque=<?= $i ?>#destaque"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Modal Adicionar Produto -->
  <div class="modal fade" id="modalProduto" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Cadastrar Produto</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="nome" class="form-control mb-2" placeholder="Nome do produto" required>
          <textarea name="descricao" class="form-control mb-2" placeholder="Descrição do produto"></textarea>
          <input type="number" name="preco" class="form-control mb-2" placeholder="Preço" required>
          <select name="categoria_id" class="form-control mb-2" required>
            <option value="">Selecione a Categoria</option>
            <?php
            $categoriasModal = $conn->query("SELECT * FROM categorias ORDER BY nome ASC");
            while ($categoria = $categoriasModal->fetch_assoc()):
              ?>
              <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
            <?php endwhile; ?>
          </select>
          <label class="form-label">Imagem (obrigatória)</label>
          <input type="file" name="imagem" class="form-control mb-2" required>
          <div class="form-check">
            <input type="checkbox" name="destaque" class="form-check-input" id="destaque">
            <label class="form-check-label" for="destaque">Destaque</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_produto" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Adicionar Produto Banner -->
  <div class="modal fade" id="modalProdutoBanner" tabindex="-1">
   
    <div class="modal-dialog">
      <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Cadastrar Produto Banner  </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="nome" class="form-control mb-2" placeholder="Nome do produto" required>
        <textarea name="descricao" class="form-control mb-2" placeholder="Descrição do produto"></textarea>
        <input type="number" name="preco" class="form-control mb-2" placeholder="Preço" required>
        <select name="categoria_id" class="form-control mb-2" required>
        <option value="">Selecione a Categoria</option>
        <?php
        $categorias1Modal = $conn->query("SELECT * FROM categorias ORDER BY nome ASC LIMIT 10");
        while ($categoria1 = $categorias1Modal->fetch_assoc()):
          ?>
          <option value="<?= $categoria1['id'] ?>"><?= $categoria1['nome'] ?></option>
        <?php endwhile; ?>
        </select>
        <label class="form-label">Imagem (obrigatória)</label>
        <input type="file" name="imagem" class="form-control mb-2" required>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_baner" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
   
  </div>

  <!-- Modal Editar Produto -->
  <div class="modal fade" id="modalEditProduto" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Editar Produto</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <input type="text" name="nome" id="edit_nome" class="form-control mb-2" placeholder="Nome do produto"
            required>
          <textarea name="descricao" id="edit_descricao" class="form-control mb-2"
            placeholder="Descrição do produto"></textarea>
          <input type="number" name="preco" id="edit_preco" class="form-control mb-2" placeholder="Preço" required>
          <select name="categoria_id" id="edit_categoria_id" class="form-control mb-2" required>
            <option value="">Selecione a Categoria</option>
            <?php
            $categoriasEdit = $conn->query("SELECT * FROM categorias ORDER BY nome ASC");
            while ($categoria = $categoriasEdit->fetch_assoc()):
              ?>
              <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
            <?php endwhile; ?>
          </select>
          <label class="form-label">Imagem (obrigatória)</label>
          <input type="file" name="imagem" id="edit_imagem" class="form-control mb-2">
          <input type="hidden" name="imagem_atual" id="edit_imagem_atual">
          <div class="form-check">
            <input type="checkbox" name="destaque" class="form-check-input" id="edit_destaque">
            <label class="form-check-label" for="edit_destaque">Destaque</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit_produto" class="btn btn-warning">Atualizar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Modal Editar Produto Banner-->
   

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <script>
    function editarProduto(id) {
      // Carregar os dados do produto no modal
      fetch('editar_produto.php?id=' + id)
        .then(response => response.json())
        .then(data => {
          document.getElementById('edit_id').value = data.id;
          document.getElementById('edit_nome').value = data.nome;
          document.getElementById('edit_descricao').value = data.descricao;
          document.getElementById('edit_preco').value = data.preco;
          document.getElementById('edit_categoria_id').value = data.categoria_id;
          document.getElementById('edit_imagem_atual').value = data.imagem;
          document.getElementById('edit_destaque').checked = data.destaque;
        });
    }
  </script>
</body>

</html>