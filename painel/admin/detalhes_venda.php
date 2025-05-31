<?php
$id = $_GET['id'] ?? 0;
include '../../conexao.php';

$sqlVenda = "SELECT * FROM vendas v
              JOIN usuarios u ON v.vendido_por = u.id
              WHERE id_venda = ?";
$stmtVenda = mysqli_prepare($conn, $sqlVenda);
mysqli_stmt_bind_param($stmtVenda, 'i', $id);
mysqli_stmt_execute($stmtVenda);
$resultVenda = mysqli_stmt_get_result($stmtVenda);
$dadosVenda = mysqli_fetch_assoc($resultVenda);

if ($dadosVenda) {
echo <<<HTML
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 20px;
      animation: fadeIn 1s ease-in-out;
    }

    .venda-container {
      max-width: 700px;
      margin: 0 auto;
      background: #fff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      animation: slideUp 1s ease-out;
    }

    .btn-imprimir {
      display: inline-block;
      margin: 15px auto;
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .btn-imprimir:hover {
      background-color: #218838;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    p {
      font-size: 16px;
      color: #444;
      margin: 6px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      animation: fadeIn 1.5s ease-in-out;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #007bff;
      color: #fff;
    }

    td {
      background-color: #f4f7fa;
    }

    .total {
      font-size: 18px;
      font-weight: bold;
      color: #28a745;
      margin-top: 20px;
      text-align: right;
    }

    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
    }

    @keyframes slideUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @media print {
      .btn-imprimir {
        display: none;
      }
    }
  </style>

  <div id="fatura" class="venda-container">
    <h2>🧾 Detalhes da Venda</h2>
HTML;

  echo "<p><strong>Cliente:</strong> " . htmlspecialchars($dadosVenda['nome_cliente']) . "</p>";

  function nomeMesPortugues($data)
  {
    $meses = [
      1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
      5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
      9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
    ];
    $timestamp = strtotime($data);
    $dia = date('d', $timestamp);
    $mes = (int) date('m', $timestamp);
    $ano = date('Y', $timestamp);
    return "$dia de " . $meses[$mes] . " de $ano";
  }

  echo "<p><strong>Data:</strong> " . nomeMesPortugues($dadosVenda['data_venda']) . "</p>";
  echo "<p><strong>Vendido por:</strong> " . htmlspecialchars($dadosVenda['nome']) . "</p>";

  $sqlItens = "SELECT vi.quantidade, vi.preco_unitario, p.nome 
               FROM vendas_itens vi
               JOIN produtos p ON vi.produto_id = p.id
               WHERE vi.venda_id = ?";
  $stmtItens = mysqli_prepare($conn, $sqlItens);
  mysqli_stmt_bind_param($stmtItens, 'i', $id);
  mysqli_stmt_execute($stmtItens);
  $resultItens = mysqli_stmt_get_result($stmtItens);

  $totalVenda = 0;
  echo "<table>";
  echo "<tr><th>Produto</th><th>Quantidade</th><th>Preço Unitário</th><th>Total</th></tr>";

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
    echo "<td>" . (int) $dados['quantidade'] . "</td>";
    echo "<td>Kz " . number_format($dados['preco_unitario'], 2, ',', '.') . "</td>";
    echo "<td>Kz " . number_format($totalItem, 2, ',', '.') . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "<p class='total'>Total da Venda: Kz " . number_format($totalVenda, 2, ',', '.') . "</p>";
  echo "</div>";
  echo <<<HTML
    <div style='text-align: center; margin-top: 20px;'>
      <p>Obrigado por sua compra! Se tiver dúvidas, entre em contato conosco.</p>
      <p>📞 Telefone: (123) 456-7890 | 📧 Email: suporte@exemplo.com</p>
      <!-- <button class='btn-imprimir' onclick='imprimirFatura()'>🖨️ Imprimir Fatura</button> -->
    </div>

    <script>
      function imprimirFatura() {
        alert('Preparando a impressão...');
        var conteudo = document.getElementById('fatura').innerHTML;
        var janelaImpressao = window.open('', '', 'height=700,width=900');
        janelaImpressao.document.write('<html><head><title>Imprimir Fatura</title>');

        var styles = document.querySelectorAll("style, link[rel='stylesheet']");
        styles.forEach(function (style) {
          janelaImpressao.document.write(style.outerHTML);
        });

        janelaImpressao.document.write('</head><body>');
        janelaImpressao.document.write(conteudo);
        janelaImpressao.document.write('</body></html>');
        janelaImpressao.document.close();
        janelaImpressao.focus();
        setTimeout(function () {
          janelaImpressao.print();
          janelaImpressao.close();
        }, 500);
      }
    </script>
HTML;
} else {
  echo "<p>Venda não encontrada.</p>";
}
?>
