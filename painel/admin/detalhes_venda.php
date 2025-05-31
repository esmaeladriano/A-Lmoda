<?php
$id = $_GET['id'] ?? 0;

include '../../conexao.php';

// Busca dados da venda
$sqlVenda = "SELECT * FROM vendas v
              JOIN usuarios u ON v.vendido_por = u.id
              WHERE id_venda = ?";
$stmtVenda = mysqli_prepare($conn, $sqlVenda);
mysqli_stmt_bind_param($stmtVenda, 'i', $id);
mysqli_stmt_execute($stmtVenda);
$resultVenda = mysqli_stmt_get_result($stmtVenda);
$dadosVenda = mysqli_fetch_assoc($resultVenda);

if ($dadosVenda) {
    echo "<p><strong>Cliente:</strong> " . htmlspecialchars($dadosVenda['nome_cliente']) . "</p>";
    echo "<p><strong>Data:</strong> " . htmlspecialchars($dadosVenda['data_venda']) . "</p>";
    echo "<p><strong>Vendido por:</strong> " . htmlspecialchars($dadosVenda['nome']) . "</p>";

    // Busca itens da venda com dados dos produtos
    $sqlItens = "SELECT vi.quantidade, vi.preco_unitario, p.nome 
                 FROM vendas_itens vi
                 JOIN produtos p ON vi.produto_id = p.id
                 WHERE vi.venda_id = ?";
    $stmtItens = mysqli_prepare($conn, $sqlItens);
    mysqli_stmt_bind_param($stmtItens, 'i', $id);
    mysqli_stmt_execute($stmtItens);
    $resultItens = mysqli_stmt_get_result($stmtItens);

    $totalVenda = 0;
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Produto</th><th>Quantidade</th><th>Preço Unitário</th><th>Total</th></tr>";

    // Agrupa itens por produto
    $produtos = [];
    while ($item = mysqli_fetch_assoc($resultItens)) {
      $nome = $item['nome'];
      if (!isset($produtos[$nome])) {
        $produtos[$nome] = [
          'quantidade' => 0,
          'preco_unitario' => $item['preco_unitario']
        ];
      }
      $produtos[$nome]['quantidade'] += $item['quantidade'];
    }

    foreach ($produtos as $nome => $dados) {
      $totalItem = $dados['quantidade'] * $dados['preco_unitario'];
      $totalVenda += $totalItem;

      echo "<tr>";
      echo "<td>" . htmlspecialchars($nome) . "</td>";
      echo "<td>" . (int)$dados['quantidade'] . "</td>";
      echo "<td>R$ " . number_format($dados['preco_unitario'], 2, ',', '.') . "</td>";
      echo "<td>R$ " . number_format($totalItem, 2, ',', '.') . "</td>";
      echo "</tr>";
    }
    echo "</table>";

    echo "<p><strong>Total da Venda:</strong> R$ " . number_format($totalVenda, 2, ',', '.') . "</p>";
} else {
    echo "<p>Venda não encontrada.</p>";
}
