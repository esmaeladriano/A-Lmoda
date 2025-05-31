<?php
include_once('C:\xampp\htdocs\A&Lmoda\conexao.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  if ($data['acao'] === 'cadastrar') {
    $nome_cliente = $data['nome_cliente'];
    $tipo_pagamento = $data['tipo_pagamento'];
    $vendido_por = $_SESSION['usuario_id']; // Supondo que o ID do usuário esteja na sessão

    $stmt = $conn->prepare("INSERT INTO vendas (nome_cliente, data_venda, tipo_pagamento, vendido_por) VALUES (?, NOW(), ?, ?)");
    $stmt->bind_param("ssi", $nome_cliente, $tipo_pagamento, $vendido_por);
    $stmt->execute();
    $id_venda = $stmt->insert_id;

    // Corrigido: nome correto da tabela e uso de prepared statement
    foreach ($data['itens'] as $item) {
      $stmtItem = $conn->prepare("INSERT INTO vendas_itens (venda_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
      $stmtItem->bind_param("iiid", $id_venda, $item['id_produto'], $item['quantidade'], $item['preco_unitario']);
      $stmtItem->execute();
    }

    echo json_encode("ok");
    exit;
  }

  if ($data['acao'] === 'excluir') {
    $id_venda = $data['id_venda'];

    // Corrigido: nome correto da tabela de itens
    $stmt = $conn->prepare("DELETE FROM vendas_itens WHERE venda_id = ?");
    $stmt->bind_param("i", $id_venda);
    $stmt->execute();

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
          <th>ID</th>
          <th>Cliente</th>
          <th>Data</th>
          <th>Pagamento</th>
          <th>Ações</th>
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
              <button class="btn btn-info btn-sm" onclick="abrirDetalhesVenda(<?= $v['id_venda'] ?>)">🔍 Detalhes</button>

            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <!-- Criando modal abrirDetalhesVenda -->

    <!-- Modal Detalhes da Venda -->
    <div class="modal fade" id="modalDetalhesVenda" tabindex="-1" aria-labelledby="modalDetalhesVendaLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg"> <!-- Pode usar modal-xl se quiser mais largo -->
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetalhesVendaLabel">📄 Detalhes da Venda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" id="conteudoDetalhesVenda">
            <!-- Conteúdo dinâmico via JavaScript -->
            <p>Carregando detalhes...</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>


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
                  <select name="nome_cliente" id="usuario_sistema" class="form-control">
                    <option value="">Usuário do Sistema</option>
                    <?php
                    // Exemplo: buscar usuários do sistema (ajuste conforme sua tabela de usuários)
                    $usuarios = $conn->query("SELECT id, nome FROM usuarios");
                    while ($u = $usuarios->fetch_assoc()):
                      ?>
                      <option value="<?= $u['nome'] ?>"><?= $u['nome'] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="col">
                  <input type="text" name="nome_cliente" id="nome_cliente" required class="form-control"
                    placeholder="Nome do Cliente">
                </div>

                <div class="col">
                  <select name="tipo_pagamento" class="form-control" required>
                    <option value="">Pagamento</option>
                    <option>Dinheiro</option>
                    <option>Transferência</option>
                    <option>Cartão</option>
                  </select>
                </div>
              </div>


              <div id="itens-container"></div>
              <button type="button" class="btn btn-secondary mt-2" onclick="addItem()"
                id="add-produto-btn">➕Produto</button>
              <!-- Vais -->

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
          <label for="id_produto">Produto</label>
          <select class="form-control produto-select" required>
            <option value="">Produto</option>
            <?php foreach ($produtos as $p): ?>
              <option value="<?= $p['id'] ?>" data-preco="<?= $p['preco'] ?>"><?= $p['nome'] ?>
                (<?= number_format($p['preco'], 2, ',', '.') ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col">
          <label for="quantidade">Quantidade</label>
          <input type="number" name="quantidade" min="1" class="form-control quantidade-input" placeholder="Qtd"
            required>
        </div>
        <div class="col">
          <label for="preco_unitario">Preço</label>
          <input type="number" step="0.01" name="preco_unitario" class="form-control preco-input" placeholder="Preço"
            required readonly>
        </div>
        <div class="col">
          <label for="total_produto">Total</label>
          <input type="number" name="total_produto" class="form-control total-input" readonly>
        </div>
        <div class="col">
          <br>
          <button type="button" class="btn btn-danger" onclick="this.closest('.item-produto').remove()">✖</button>
        </div>
      </div>
    </template>

    <script>
      function abrirDetalhesVenda(idVenda) {
        // Exibe o modal
        const modal = new bootstrap.Modal(document.getElementById('modalDetalhesVenda'));
        modal.show();

        // Limpa e mostra carregando
        document.getElementById('conteudoDetalhesVenda').innerHTML = '<p>Carregando detalhes...</p>';

        // Faz a requisição AJAX
        fetch('detalhes_venda.php?id=' + idVenda)
          .then(response => response.text())
          .then(data => {
            document.getElementById('conteudoDetalhesVenda').innerHTML = data;
          })
          .catch(error => {
            document.getElementById('conteudoDetalhesVenda').innerHTML = '<p class="text-danger">Erro ao carregar os detalhes.</p>';
          });
      }
    </script>


    <script>
      // Função para calcular o total do item
      function calcularTotalItem(itemRow) {
        const qtdInput = itemRow.querySelector('.quantidade-input');
        const precoInput = itemRow.querySelector('.preco-input');
        const totalInput = itemRow.querySelector('.total-input');
        const quantidade = parseFloat(qtdInput.value) || 0;
        const preco = parseFloat(precoInput.value) || 0;
        totalInput.value = (quantidade * preco).toFixed(2);
      }

      // Evento delegado para inputs de quantidade
      document.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantidade-input')) {
          const itemRow = e.target.closest('.item-produto');
          calcularTotalItem(itemRow);
        }
      });

      // Também calcula ao alterar o preço (caso necessário)
      document.addEventListener('input', function (e) {
        if (e.target.classList.contains('preco-input')) {
          const itemRow = e.target.closest('.item-produto');
          calcularTotalItem(itemRow);
        }
      });
    </script>

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



      // Garante que pelo menos um item seja adicionado antes de enviar o formulário e faz o envio AJAX
      document.getElementById('form-venda').addEventListener('submit', function (e) {
        e.preventDefault();
        if (document.querySelectorAll('.item-produto').length === 0) {
          alert('Adicione pelo menos um produto à venda!');
          window.scrollTo(0, 0);
          document.getElementById('add-produto-btn').focus();
          return false;
        }

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

    <script>
      // Se selecionar usuário, desabilita nome_cliente e vice-versa
      document.addEventListener('DOMContentLoaded', function () {
        const usuarioSelect = document.getElementById('usuario_sistema');
        const clienteInput = document.getElementById('nome_cliente');

        usuarioSelect.addEventListener('change', function () {
          if (this.value) {
            clienteInput.value = this.value;
            clienteInput.disabled = true;
          } else {
            clienteInput.value = '';
            clienteInput.disabled = false;
          }
        });

        clienteInput.addEventListener('input', function () {
          if (this.value) {
            usuarioSelect.value = '';
            usuarioSelect.disabled = true;
          } else {
            usuarioSelect.disabled = false;
          }
        });
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>