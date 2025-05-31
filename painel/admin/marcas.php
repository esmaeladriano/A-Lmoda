<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();
// CADASTRAR MARCA
if (isset($_POST['add_marca'])) {
  $nome = trim($_POST['nome']);
  $descricao = trim($_POST['descricao']);
  $logo_nome = '';

  // Verificar se já existe
  $verifica = $conn->prepare("SELECT id FROM marcas WHERE nome = ?");
  $verifica->bind_param("s", $nome);
  $verifica->execute();
  $verifica->store_result();

  if ($verifica->num_rows > 0) {
    echo "<script>alert('❗ Marca já existe!'); window.location.href='marcas.php';</script>";
    exit;
  }

  // Upload da logo com validação de extensão e tamanho
  if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
    $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
    $tamanho_max = 2 * 1024 * 1024; // 2MB

    if (!in_array($ext, $ext_permitidas)) {
      echo "<script>alert('❗ Extensão de imagem não permitida!'); window.location.href='marcas.php';</script>";
      exit;
    }

    if ($_FILES['logo']['size'] > $tamanho_max) {
      echo "<script>alert('❗ Imagem muito grande! Máximo 2MB.'); window.location.href='marcas.php';</script>";
      exit;
    }

    $logo_nome = uniqid() . "." . $ext;
    if (!move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/" . $logo_nome)) {
      echo "<script>alert('❗ Erro ao salvar a imagem!'); window.location.href='marcas.php';</script>";
      exit;
    }
  }

  // Inserir no banco
  $stmt = $conn->prepare("INSERT INTO marcas (nome, descricao, logo) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $nome, $descricao, $logo_nome);
  $stmt->execute();

  echo "<script>alert('✅ Marca adicionada com sucesso!'); window.location.href='marcas.php';</script>";
}

// EXCLUIR MARCA
if (isset($_POST['delete_marca'])) {
  $id = $_POST['id'];
  $conn->query("DELETE FROM marcas WHERE id=$id");
  echo "<script>alert('🗑 Marca excluída.'); window.location.href='marcas.php';</script>";
}

// LISTAR MARCAS
$marcas = $conn->query("SELECT * FROM marcas ORDER BY data_cadastro DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Marcas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include_once('./navbar.php'); ?>
<div class="main-content" style="margin-top: 56px;">
  <div class="d-flex justify-content-between mb-3">
    <h3><i class="fas fa-tags"></i> Marcas</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMarca">+ Nova Marca</button>
  </div>

  <table class="table table-hover table-bordered align-middle">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Logo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($marca = $marcas->fetch_assoc()): ?>
        <tr>
          <td><?= $marca['id'] ?></td>
          <td><?= $marca['nome'] ?></td>
          <td><?= $marca['descricao'] ?></td>
          <td>
            <?php if ($marca['logo']): ?>
              <img src="uploads/<?= $marca['logo'] ?>" alt="Logo" width="50">
            <?php else: ?>
              <em>Sem logo</em>
            <?php endif; ?>
          </td>
          <td>
            <form method="POST" class="d-inline">
              <input type="hidden" name="id" value="<?= $marca['id'] ?>">
              <button type="submit" name="delete_marca" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir esta marca?')">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal Adicionar Marca -->
<div class="modal fade" id="modalMarca" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Cadastrar Marca</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="nome" class="form-control mb-2" placeholder="Nome da marca" required>
        <textarea name="descricao" class="form-control mb-2" placeholder="Descrição da marca"></textarea>
        <label class="form-label">Logo *</label>
        <input type="file" name="logo" required class="form-control mb-2">
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_marca" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
