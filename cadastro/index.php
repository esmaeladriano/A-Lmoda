<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro de Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="cadastro.css">
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

input.form-control,
select.form-select {
  border-radius: 10px;
  border: 1px solid #ccc;
  padding: 10px;
  transition: all 0.3s ease;
}

input:focus,
select:focus {
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
      <form>
        <div class="mb-3">
          <label for="nome" class="form-label">Nome completo *</label>
          <input type="text" class="form-control" id="nome" placeholder="Digite seu nome completo" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email *</label>
          <input type="email" class="form-control" id="email" placeholder="exemplo@email.com" required>
        </div>
        <div class="mb-3">
          <label for="senha" class="form-label">Senha *</label>
          <input type="password" class="form-control" id="senha" placeholder="Crie uma senha segura" required>
        </div>
      
        <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm">Cadastrar</button>
      </form>
    </div>
  </section>
</body>
</html>
