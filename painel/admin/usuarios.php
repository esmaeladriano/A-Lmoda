<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();

// CADASTRAR
// CADASTRAR
if (isset($_POST['create_user'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    // Verificar se email já existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();



    if ($check->num_rows > 0) {
        echo '<script> showAlert("O Email já exite na base de dados!", "warning");</script>';
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);
        if ($stmt->execute()) {
            echo (' <script> showAlert("O Email já exite na base de dados!", "success");</script>');
        } else {
            echo'<script> showAlert("Erro ao cadstrar!", "danger"");</script>';;
        }
    }
}

// EDITAR
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];
    $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=?, tipo=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $email, $tipo, $id);
    $stmt->execute();
}

// EXCLUIR
if (isset($_POST['delete_user'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Listar usuários
$usuarios = $conn->query("SELECT * FROM usuarios ORDER BY data_cadastro DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="bg-light">
    <?php include_once('./navbar.php'); ?>

    <div class="main-content" style="margin-top: 56px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark"><i class="fas fa-users me-2"></i>Gestão de Usuários</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus me-1"></i> Novo Usuário
            </button>
        </div>


        <!-- Tabela Bootstrap Responsiva -->
        <div class="table-responsive mt-5">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Data de Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usuarios->data_seek(0);
                    $index = 1;
                    while ($user = $usuarios->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $index++ ?></td>
                            <td><?= $user['nome'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= ucfirst($user['tipo']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($user['data_cadastro'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="delete_user" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja excluir este usuário?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Novo Usuário -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Novo Usuário</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nome" class="form-control mb-2" placeholder="Nome" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="password" name="senha" class="form-control mb-2" placeholder="Senha" required>
                    <select name="tipo" class="form-select" required>
                        <option value="cliente">Cliente</option>
                        <option value="admin">Administrador</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button name="create_user" type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Container onde os alertas vão aparecer -->
    <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1055;"></div>

    <script>
        function showAlert(message, type = 'success') {
            const alertId = 'alert-' + Math.floor(Math.random() * 10000);

            const alert = `
    <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
  `;

            document.getElementById('alert-container').insertAdjacentHTML('beforeend', alert);

            // Remover automaticamente após 5 segundos
            setTimeout(() => {
                const element = document.getElementById(alertId);
                if (element) element.classList.remove("show");
            }, 5000);
        }
 
    </script>

    <!-- Bootstrap e Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>