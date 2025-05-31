<?php
session_start();
include_once('conexao.php');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
        <!-- Carrinho -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🛒 Seu Carrinho</h5>
                </div>
                <div class="card-body">
                    <?php
                    if (!isset($_SESSION['usuario_id'])) {
                        echo "<div class='alert alert-warning'>⚠️ Faça login para ver o carrinho.</div>";
                        echo "<a href='login' class='btn btn-primary'>Login</a>";

                        exit;
                    }

                    $id_usuario = $_SESSION['usuario_id'];
                    $sql = "SELECT p.nome, SUM(c.quantidade) as quantidade_total, p.preco 
                        FROM carrinho c 
                        JOIN produtos p ON c.id_produto = p.id 
                        WHERE c.id_usuario = ?
                        GROUP BY p.id, p.nome, p.preco";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows === 0) {
                        echo "<div class='alert alert-info text-center'>🛒 Seu carrinho está vazio.</div>";
                        exit;
                    }

                    $total = 0;
                    echo '<ul class="list-group">';
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['preco'] * $row['quantidade_total'];
                        $total += $subtotal;
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                        echo htmlspecialchars($row['nome']) . " <span>x" . $row['quantidade_total'] . "</span>";
                        echo '<span>KZ ' . number_format($subtotal, 2) . '</span>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    echo '<div class="mt-3 text-end"><b>Total: KZ ' . number_format($total, 2) . '</b></div>';
                    ?>
                </div>
            </div>
        </div>

        <!-- Formulário de entrega -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📦 Dados de Entrega</h5>
                </div>
                <div class="card-body">
                    <form action="processar_pedido.php" method="post">
                        <?php
                        // Preenche nome e telefone a partir da sessão, se disponíveis
                        $nome = isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : '';
                        $telefone = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
                        ?>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome; ?>" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value="<?php echo $telefone; ?>" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <textarea name="endereco" id="endereco" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="localidade" class="form-label">Localidade</label>
                            <select name="localidade" id="localidade" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="Luanda">Luanda</option>
                                <option value="Benguela">Benguela</option>
                                <option value="Huambo">Huambo</option>
                                <!-- Adicione mais conforme necessário -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pagamento" class="form-label">Forma de Pagamento</label>
                            <select name="pagamento" id="pagamento" class="form-select" required>
                                <option value="">Escolha...</option>
                                <option value="dinheiro">Dinheiro na entrega</option>
                                <option value="transferencia">Transferência bancária</option>
                                <option value="mobile">Pagamento móvel (Ex: Unitel Money)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea name="observacoes" id="observacoes" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Finalizar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
