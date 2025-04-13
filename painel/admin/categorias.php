<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();

// CREATE
if (isset($_POST['add_categoria'])) {
    $nome = trim($_POST['nome']);
  
    // Verificar se já existe
    $verifica = $conn->prepare("SELECT id FROM categorias WHERE nome = ?");
    $verifica->bind_param("s", $nome);
    $verifica->execute();
    $verifica->store_result();
  
    if ($verifica->num_rows > 0) {
      echo "<script>alert('❗ Categoria já existe!'); window.location.href='categorias.php';</script>";
    } else {
      $stmt = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
      $stmt->bind_param("s", $nome);
      $stmt->execute();
  
      echo "<script>alert('✅ Categoria adicionada com sucesso!'); window.location.href='categorias.php';</script>";
    }
  }
  

// UPDATE
if (isset($_POST['update_categoria'])) {
  $id = $_POST['id'];
  $nome = $_POST['nome'];
  $stmt = $conn->prepare("UPDATE categorias SET nome = ? WHERE id = ?");
  $stmt->bind_param("si", $nome, $id);
  $stmt->execute();
}

// DELETE
if (isset($_POST['delete_categoria'])) {
  $id = $_POST['id'];
  $stmt = $conn->prepare("DELETE FROM categorias WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

// READ
$categorias = $conn->query("SELECT * FROM categorias ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gestão de Categorias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<?php include_once('./navbar.php'); ?>
<div class="main-content" style="margin-top: 56px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-tags me-2"></i>Categorias</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Nova Categoria</button>
  </div>

  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($cat = $categorias->fetch_assoc()): ?>
        <tr>
          <td><?= $cat['id'] ?></td>
          <td><?= $cat['nome'] ?></td>
          <td>
            <!-- Editar -->
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $cat['id'] ?>">Editar</button>

            <!-- Deletar -->
            <form method="POST" class="d-inline">
              <input type="hidden" name="id" value="<?= $cat['id'] ?>">
              <button name="delete_categoria" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir esta categoria?')">Excluir</button>
            </form>
          </td>
        </tr>

        <!-- Modal Editar -->
        <div class="modal fade" id="modalEdit<?= $cat['id'] ?>" tabindex="-1">
          <div class="modal-dialog">
            <form method="POST" class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                <input type="text" name="nome" class="form-control" value="<?= $cat['nome'] ?>" required>
              </div>
              <div class="modal-footer">
                <button name="update_categoria" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Modal Adicionar -->
<div class="modal fade" id="modalAdd" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Nova Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="nome" class="form-control" placeholder="Nome da categoria" required>
      </div>
      <div class="modal-footer">
        <button name="add_categoria" class="btn btn-success">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
