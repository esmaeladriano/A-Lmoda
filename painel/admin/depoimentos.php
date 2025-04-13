<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();

// CADASTRAR
if (isset($_POST['create'])) {
    $usuario_id = $_POST['usuario_id'];
    $depoimento = $_POST['depoimento'];
    $data = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO depoimentos (usuario_id, depoimento, data_depoimento) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $usuario_id, $depoimento, $data);
    $stmt->execute();
}

// EDITAR
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $usuario_id = $_POST['usuario_id'];
    $depoimento = $_POST['depoimento'];
    $stmt = $conn->prepare("UPDATE depoimentos SET usuario_id = ?, depoimento = ? WHERE id = ?");
    $stmt->bind_param("isi", $usuario_id, $depoimento, $id);
    $stmt->execute();
}

// EXCLUIR
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM depoimentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Listar usuários
$usuarios = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome ASC");

// Listar depoimentos
$depoimentos = $conn->query("SELECT d.*, u.nome FROM depoimentos d INNER JOIN usuarios u ON d.usuario_id = u.id ORDER BY d.data_depoimento DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Depoimentos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<?php include_once('./navbar.php'); ?>
<div class="main-content" style="margin-top: 56px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-comment-dots me-2"></i>Depoimentos</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
      <i class="fas fa-plus-circle me-1"></i> Novo Depoimento
    </button>
  </div>

  <div class="row">
    <?php while ($row = $depoimentos->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-lg animate__animated animate__fadeInUp" style="transition: 0.3s; border-left: 6px solid #198754; background: linear-gradient(135deg, #e0f7fa, #ffffff);">
          <div class="card-body">
            <h5 class="card-title text-success fw-bold">
              <i class="fas fa-user-circle me-2 text-secondary"></i><?= $row['nome'] ?>
            </h5>
            <p class="card-text text-dark"><?= nl2br($row['depoimento']) ?></p>
          </div>
          <div class="card-footer bg-white border-top d-flex justify-content-between">
            <small class="text-muted"><i class="fas fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($row['data_depoimento'])) ?></small>
            <div>
              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                <i class="fas fa-edit"></i>
              </button>
              <form method="POST" class="d-inline">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" name="delete" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir este depoimento?')">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal de Edição -->
      <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
          <form method="POST" class="modal-content">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Editar Depoimento</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <select name="usuario_id" class="form-select mb-2" required>
                <?php
                $usuarios_edit = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome ASC");
                while ($user = $usuarios_edit->fetch_assoc()):
                ?>
                  <option value="<?= $user['id'] ?>" <?= $user['id'] == $row['usuario_id'] ? 'selected' : '' ?>>
                    <?= $user['nome'] ?>
                  </option>
                <?php endwhile; ?>
              </select>
              <textarea name="depoimento" class="form-control" rows="4" required><?= $row['depoimento'] ?></textarea>
            </div>
            <div class="modal-footer">
              <button name="update" type="submit" class="btn btn-primary">Salvar</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Modal de Cadastro -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Novo Depoimento</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select name="usuario_id" class="form-select mb-2" required>
          <option value="">Selecionar Usuário</option>
          <?php $usuarios->data_seek(0); while ($user = $usuarios->fetch_assoc()): ?>
            <option value="<?= $user['id'] ?>"><?= $user['nome'] ?></option>
          <?php endwhile; ?>
        </select>
        <textarea name="depoimento" class="form-control" rows="4" placeholder="Escreva o depoimento..." required></textarea>
      </div>
      <div class="modal-footer">
        <button name="create" type="submit" class="btn btn-success">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
