<?php
include_once 'C:\xampp\htdocs\A&Lmoda\conexao.php';
session_start();


header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Removido o bloco gerar_pdf

    // Atualizar status pedido para entregue
    if ($action === 'entregar_pedido' && isset($_POST['id'])) {
        $idPedido = intval($_POST['id']);
        $sql = "UPDATE pedidos SET status = 'entregue' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $idPedido);
        $success = mysqli_stmt_execute($stmt);
        echo json_encode(['success' => $success]);
        exit;
    }

    // Listar pedidos com paginação AJAX
    if ($action === 'listar') {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        // Filtros (exemplo básico)
        $where = [];
        $params = [];
        $tipos = '';

        if (!empty($_GET['cliente'])) {
            $where[] = "p.nome_cliente LIKE ?";
            $params[] = '%' . $_GET['cliente'] . '%';
            $tipos .= 's';
        }

        if (!empty($_GET['data_de'])) {
            $where[] = "DATE(p.data_pedido) >= ?";
            $params[] = $_GET['data_de'];
            $tipos .= 's';
        }
        if (!empty($_GET['data_ate'])) {
            $where[] = "DATE(p.data_pedido) <= ?";
            $params[] = $_GET['data_ate'];
            $tipos .= 's';
        }

        $sqlWhere = '';
        if ($where) {
            $sqlWhere = 'WHERE ' . implode(' AND ', $where);
        }

        // Contagem total
        $sqlCount = "SELECT COUNT(*) AS total FROM pedidos p $sqlWhere";
        $stmtCount = mysqli_prepare($conn, $sqlCount);
        if ($params) {
            mysqli_stmt_bind_param($stmtCount, $tipos, ...$params);
        }
        mysqli_stmt_execute($stmtCount);
        $resCount = mysqli_stmt_get_result($stmtCount);
        $totalRows = mysqli_fetch_assoc($resCount)['total'];

        // Consulta pedidos
        $sql = "SELECT p.*, u.nome AS nome_usuario 
                FROM pedidos p
                JOIN usuarios u ON p.id_usuario = u.id
                $sqlWhere
                ORDER BY p.data_pedido DESC
                LIMIT ? OFFSET ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($params) {
            $tipos .= 'ii';
            $params[] = $limit;
            $params[] = $offset;
            mysqli_stmt_bind_param($stmt, $tipos, ...$params);
        } else {
            mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
        }

        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        $pedidos = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $pedidos[] = $row;
        }

        echo json_encode([
            'pedidos' => $pedidos,
            'total' => $totalRows,
            'page' => $page,
            'pages' => ceil($totalRows / $limit),
        ]);
        exit;
    }
}

// Se chegou aqui, não é requisição AJAX, mostrar página HTML com interface

header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <?php include_once './navbar.php'; ?>
      <div class="main-content" style="margin-top: 40px;">


    <main class="container py-4">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form class="row g-3 align-items-end mb-4" id="form-filtros">
                            
            

                            <div class="col-md-2 d-grid d-none">
                                <button id="btn-filtrar" type="button" class="btn btn-primary">Filtrar</button>
                            </div>
                        </form>

                        <div id="pedidos-container"></div>
                        <nav>
                            <div id="paginacao" class="btn-group mt-3"></div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Marcar Entregue -->
    <div class="modal fade" id="modalEntregar" tabindex="-1" aria-labelledby="modalEntregarLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEntregar">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEntregarLabel">Confirmar Entrega</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        Deseja marcar o pedido <span id="pedido-numero"></span> como entregue?
                        <input type="hidden" id="entregar-id" name="id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modalEntregar = new bootstrap.Modal(document.getElementById('modalEntregar'));

        function carregarPedidos(page = 1) {
     
           

            const params = new URLSearchParams({
                action: 'listar',
                page: page,
            });

           
    

            fetch('<?= basename(__FILE__) ?>?' + params.toString())
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('pedidos-container');
                    container.innerHTML = '';

                    if (data.pedidos.length === 0) {
                        container.innerHTML = '<p class="text-center text-muted">Nenhum pedido encontrado.</p>';
                        document.getElementById('paginacao').innerHTML = '';
                        return;
                    }

                    data.pedidos.forEach(p => {
                        const card = document.createElement('div');
                        card.classList.add('card', 'mb-3');
                        card.innerHTML = `
                        <div class="card-header d-flex justify-content-between align-items-center bg-light"></div>
                            <div>
                                <span class="fw-bold">Pedido #${p.id}</span> — ${p.nome_cliente} <span class="text-muted">(${p.telefone})</span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-success me-1 btn-entregar" data-id="${p.id}" ${p.status === 'entregue' ? 'disabled' : ''}>
                                    ${p.status === 'entregue' ? 'Entregue' : 'Marcar Entregue'}
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Endereço:</strong> ${p.endereco}, ${p.localidade}</p>
                                    <p><strong>Pagamento:</strong> ${p.pagamento}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Data:</strong> ${new Date(p.data_pedido).toLocaleString()}</p>
                                    <p><strong>Status:</strong> <span class="badge ${p.status === 'entregue' ? 'bg-success' : 'bg-warning text-dark'}">${p.status}</span></p>
                                </div>
                            </div>
                            <nav class="mt-3">
                                <ul class="nav nav-tabs" id="pedidoTabs-${p.id}" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="info-tab-${p.id}" data-bs-toggle="tab" data-bs-target="#info-${p.id}" type="button" role="tab" aria-controls="info-${p.id}" aria-selected="true">Informações</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="itens-tab-${p.id}" data-bs-toggle="tab" data-bs-target="#itens-${p.id}" type="button" role="tab" aria-controls="itens-${p.id}" aria-selected="false">Itens</button>
                                    </li>
                                </ul>
                                <div class="tab-content border border-top-0 p-3" id="pedidoTabsContent-${p.id}">
                                    <div class="tab-pane fade show active" id="info-${p.id}" role="tabpanel" aria-labelledby="info-tab-${p.id}">
                                        <p><strong>Cliente:</strong> ${p.nome_cliente}</p>
                                        <p><strong>Telefone:</strong> ${p.telefone}</p>
                                        <p><strong>Endereço:</strong> ${p.endereco}, ${p.localidade}</p>
                                        <p><strong>Pagamento:</strong> ${p.pagamento}</p>
                                        <p><strong>Status:</strong> <span class="badge ${p.status === 'entregue' ? 'bg-success' : 'bg-warning text-dark'}">${p.status}</span></p>
                                    </div>
                                    <div class="tab-pane fade" id="itens-${p.id}" role="tabpanel" aria-labelledby="itens-tab-${p.id}">
                                        <div id="itens-list-${p.id}">Carregando itens...</div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        `;
                        container.appendChild(card);

                        // Carregar itens do pedido ao abrir a aba "Itens"
                        const itensTab = card.querySelector(`#itens-tab-${p.id}`);
                        if (itensTab) {
                            itensTab.addEventListener('shown.bs.tab', function () {
                                const itensDiv = document.getElementById(`itens-list-${p.id}`);
                                if (itensDiv && !itensDiv.dataset.loaded) {
                                    fetch('<?= basename(__FILE__) ?>?action=itens_pedido&id=' + p.id)
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.length === 0) {
                                                itensDiv.innerHTML = '<p class="text-muted">Nenhum item encontrado.</p>';
                                            } else {
                                                itensDiv.innerHTML = '<ul class="list-group">' +
                                                    data.map(item => `<li class="list-group-item d-flex justify-content-between align-items-center">
                                                        ${item.nome_produto} <span class="badge bg-primary rounded-pill">${item.quantidade}</span>
                                                    </li>`).join('') +
                                                    '</ul>';
                                            }
                                            itensDiv.dataset.loaded = "1";
                                        });
                                }
                            });
                        }
                    });

                    // Paginação
                    const paginacao = document.getElementById('paginacao');
                    paginacao.innerHTML = '';

                    for (let i = 1; i <= data.pages; i++) {
                        const btn = document.createElement('button');
                        btn.classList.add('btn', 'btn-outline-primary');
                        if (i === data.page) btn.classList.add('active');
                        btn.textContent = i;
                        btn.addEventListener('click', () => carregarPedidos(i));
                        paginacao.appendChild(btn);
                    }

                    // Botões Entregar
                    document.querySelectorAll('.btn-entregar').forEach(btn => {
                        btn.addEventListener('click', e => {
                            const id = e.target.getAttribute('data-id');
                            document.getElementById('entregar-id').value = id;
                            document.getElementById('pedido-numero').textContent = id;
                            modalEntregar.show();
                        });
                    });
                });
        }

        document.getElementById('btn-filtrar').addEventListener('click', () => carregarPedidos(1));

        document.getElementById('formEntregar').addEventListener('submit', e => {
            e.preventDefault();
            const id = document.getElementById('entregar-id').value;

            fetch('<?= basename(__FILE__) ?>?action=entregar_pedido', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ id }),
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        modalEntregar.hide();
                        carregarPedidos();
                    } else {
                        alert('Erro ao atualizar status.');
                    }
                });
        });

        // Carregar pedidos inicial
        carregarPedidos();
    </script>
</body>

</html>