<?php
  include_once '../conexao.php';
// PROCESSAMENTO PHP
$response = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = password_hash(trim($_POST['senha']), PASSWORD_DEFAULT);
  $nivel = 'cliente';



  if (!$conn) {
    $response = ['status' => 'error', 'message' => 'Erro de conexão com o banco!'];
  } else {
    $check = mysqli_query($conn, "SELECT id FROM usuarios WHERE email = '$email' LIMIT 1");
    if (mysqli_num_rows($check) > 0) {
      $response = ['status' => 'warning', 'message' => '⚠️ Este email já está em uso!'];
    } else {
      $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', '$nivel')";
      if (mysqli_query($conn, $sql)) {
        $response = ['status' => 'success', 'message' => '✅ Usuário cadastrado com sucesso!'];
      } else {
        $response = ['status' => 'error', 'message' => '❌ Erro ao cadastrar usuário!'];
      }
    }
    mysqli_close($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro de Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #fffbe6, #fef9e7);
    }

    .card {
      background: #fff;
      border: none;
      animation: fadeInUp 0.8s ease;
    }

    input.form-control {
      border-radius: 10px;
      border: 1px solid #ccc;
      padding: 10px;
      transition: all 0.3s ease;
    }

    input:focus {
      border-color: #ffc107;
      box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    button.btn-warning {
      border-radius: 8px;
      transition: 0.3s ease-in-out;
    }

    button.btn-warning:hover {
      background-color: #e0aa06;
      color: white;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <section class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card p-4 shadow-lg rounded-4" style="max-width: 500px; width: 100%;">
      <div class="text-center mb-4">
        <h3 class="fw-bold text-warning">📝 Criar Conta</h3>
        <p class="text-muted">Preencha os dados abaixo para se cadastrar</p>
      </div>
      <form method="POST" action="">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome completo *</label>
          <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email *</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@email.com" required>
        </div>
        <div class="mb-3">
          <label for="senha" class="form-label">Senha *</label>
          <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha segura" required>
        </div>

        <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm">Cadastrar</button>
      </form>
    </div>
  </section>

  <?php if ($response): ?>
    <script>
      Swal.fire({
        icon: '<?= $response['status'] ?>',
        title: '<?= $response['message'] ?>',
        showConfirmButton: false,
        timer: 3000
      });
    </script>
  <?php endif; ?>
</body>
</html>
