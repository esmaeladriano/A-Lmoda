<?php
session_start();
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validação básica para evitar SQL Injection e entradas inválidas
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email inválido.";
        header("Location: http://localhost/A&Lmoda/login/");
        exit();
    }

    // Usando prepared statements já protege contra SQL Injection
    $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error'] = "Erro no servidor. Tente novamente.";
        header("Location: http://localhost/A&Lmoda/login/");
        exit();
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            $_SESSION['email'] = $usuario['email'];

            if ($usuario['tipo'] == 'admin') {
                header("Location:http://localhost/A&Lmoda/painel/admin/");
            } else {
                header("Location: http://localhost/A&Lmoda/");
            }
            exit();
        } else {
            $_SESSION['error'] = "Email ou senha inválidos.";
            header("Location: http://localhost/A&Lmoda/login/");
            exit();
        }
    } else {
        $_SESSION['error'] = "Usuário não existe no sistema.";
        header("Location: http://localhost/A&Lmoda/login/");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - A&L Moda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #ffc107;
            border-color: #ffc107;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e0aa06;
            border-color: #e0aa06;
        }

        .senha a, .register-link a {
            text-decoration: none;
        }

        .senha a:hover, .register-link a:hover {
            text-decoration: underline;
        }
        .body{
            background-color:#00FF66;
        }
       
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center">Login</h3>

            <?php
            if (!empty($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email: *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha: *</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-secondary w-100">Entrar</button>

                <div class="register-link mt-3 text-center">
                    <p>Não tem uma conta? <a href="../cadastro/">Cadastre-se</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
