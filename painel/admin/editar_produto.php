<?php

// Conecta ao banco de dados
include '../../conexao.php'; // ajuste o caminho se necessário

// Verifica se o ID foi passado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Busca o produto no banco de dados
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $produto = $resultado->fetch_assoc();

        // Retorna os dados como JSON
        header('Content-Type: application/json');
        echo json_encode($produto);
    } else {
        // Produto não encontrado
        http_response_code(404);
        echo json_encode(['erro' => 'Produto não encontrado']);
    }
} else {
    // ID não fornecido
    http_response_code(400);
    echo json_encode(['erro' => 'ID não fornecido']);
}
