<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if ($data['acao'] === 'cadastrar') { // Vendedor vem da sessão
        $nome_cliente = $data['nome_cliente']; // Agora recebendo o nome do cliente
        $tipo_pagamento = $data['tipo_pagamento'];

        $stmt = $conn->prepare("INSERT INTO vendas (nome_cliente, data_venda, tipo_pagamento) VALUES (?, NOW(), ?)");
        $stmt->bind_param("ss", $nome_cliente, $tipo_pagamento); // Alterando para usar o nome do cliente
        $stmt->execute();
        $id_venda = $stmt->insert_id;

        foreach ($data['itens'] as $item) {
            $stmtItem = $conn->prepare("INSERT INTO itens_venda (id_venda, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
            $stmtItem->bind_param("iiid", $id_venda, $item['id_produto'], $item['quantidade'], $item['preco_unitario']);
            $stmtItem->execute();
        }

        echo json_encode("ok");
        exit;
    }

    if ($data['acao'] === 'excluir') {
        $id_venda = $data['id_venda'];

        // Excluindo os itens da venda
        $stmt = $conn->prepare("DELETE FROM itens_venda WHERE id_venda = ?");
        $stmt->bind_param("i", $id_venda);
        $stmt->execute();

        // Excluindo a venda
        $stmt = $conn->prepare("DELETE FROM vendas WHERE id_venda = ?");
        $stmt->bind_param("i", $id_venda);
        $stmt->execute();

        echo json_encode("excluido");
        exit;
    }
}

// Pegando os produtos da base de dados
$produtos = [];
$res = $conn->query("SELECT id, nome, preco FROM produtos");
while ($row = $res->fetch_assoc()) {
    $produtos[] = $row;
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Vendas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<?php include_once('./navbar.php'); ?>
<div class="main-content" style="margin-top: 56px;">
<h3>🧾 Vendas</h3>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalVenda">➕ Nova Venda</button>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th><th>Cliente</th><th>Data</th><th>Pagamento</th><th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $vendas = $conn->query("SELECT * FROM vendas ORDER BY id_venda DESC");
    while ($v = $vendas->fetch_assoc()):
    ?>
    <tr>
      <td><?= $v['id_venda'] ?></td>
      <td><?= $v['nome_cliente'] ?></td> <!-- Exibindo o nome do cliente -->
      <td><?= $v['data_venda'] ?></td>
      <td><?= $v['tipo_pagamento'] ?></td>
      <td>
        <button class="btn btn-danger btn-sm" onclick="excluirVenda(<?= $v['id_venda'] ?>)">🗑</button>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Modal de Nova Venda -->
<div class="modal fade" id="modalVenda" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-venda">
        <div class="modal-header">
          <h5 class="modal-title">🛒 Nova Venda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="acao" value="cadastrar">
          <div class="row mb-2">
            <div class="col">
              <input type="text" name="nome_cliente" class="form-control" placeholder="Nome do Cliente" required> <!-- Campo de texto para nome do cliente -->
            </div>
            <div class="col">
              <select name="tipo_pagamento" class="form-control" required>
                <option value="">Pagamento</option>
                <option>Dinheiro</option>
                <option>PIX</option>
                <option>Cartão</option>
              </select>
            </div>
          </div>

          <h6>Itens</h6>
          <div id="itens-container"></div>
          <button type="button" class="btn btn-secondary mt-2" onclick="addItem()">➕ Produto</button>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">💾 Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Template para Itens -->
<template id="item-template">
  <div class="row mb-2 item-produto">
    <div class="col">
      <select class="form-control produto-select" required>
        <option value="">Produto</option>
        <?php foreach ($produtos as $p): ?>
          <option value="<?= $p['id'] ?>" data-preco="<?= $p['preco'] ?>"><?= $p['nome'] ?> (<?= number_format($p['preco'], 2, ',', '.') ?>)</option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col"><input type="number" name="quantidade" class="form-control" placeholder="Qtd" required></div>
    <div class="col"><input type="number" step="0.01" name="preco_unitario" class="form-control" placeholder="Preço" required readonly></div>
    <div class="col-auto">
      <button type="button" class="btn btn-danger" onclick="this.closest('.item-produto').remove()">✖</button>
    </div>
  </div>
</template>

<script>
function addItem() {
  const template = document.getElementById('item-template');
  const clone = template.content.cloneNode(true);
  const select = clone.querySelector('.produto-select');
  const precoInput = clone.querySelector('[name="preco_unitario"]');

  select.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    precoInput.value = selected.dataset.preco || '';
    select.name = 'id_produto'; // define o name só após seleção
  });

  document.getElementById('itens-container').appendChild(clone);
}

document.getElementById('form-venda').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const dados = {};
  formData.forEach((v, k) => dados[k] = v);

  const itens = [];
  document.querySelectorAll('.item-produto').forEach(item => {
    itens.push({
      id_produto: item.querySelector('[name="id_produto"]').value,
      quantidade: item.querySelector('[name="quantidade"]').value,
      preco_unitario: item.querySelector('[name="preco_unitario"]').value
    });
  });
  dados['itens'] = itens;

  fetch('vendas.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(dados)
  }).then(res => res.text())
    .then(txt => {
      if (txt.includes("ok")) {
        alert("Venda salva!");
        location.reload();
      } else {
        alert("Erro: " + txt);
      }
    });
});

function excluirVenda(id) {
  if (confirm('Você tem certeza que deseja excluir esta venda?')) {
    fetch('vendas.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ acao: 'excluir', id_venda: id })
    }).then(res => res.text())
      .then(txt => {
        if (txt.includes("excluido")) {
          alert("Venda excluída!");
          location.reload();
        } else {
          alert("Erro ao excluir a venda.");
        }
      });
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
