<?php
// filepath: c:\xampp\htdocs\A&Lmoda\pesquisa.php

header('Content-Type: application/json');
include_once('conexao.php');

$nome = $_GET['nome'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$preco_min = $_GET['preco_min'] ?? '';
$preco_max = $_GET['preco_max'] ?? '';

$query = "SELECT * FROM produtos WHERE 1=1";
$params = [];
$param_types = '';

if (!empty($nome)) {
    $query .= " AND nome LIKE ?";
    $params[] = '%' . $nome . '%';
    $param_types .= 's';
}
if (!empty($categoria)) {
    $query .= " AND categoria = ?";
    $params[] = $categoria;
    $param_types .= 's';
}
if (!empty($preco_min)) {
    $query .= " AND preco >= ?";
    $params[] = $preco_min;
    $param_types .= 'd';
}
if (!empty($preco_max)) {
    $query .= " AND preco <= ?";
    $params[] = $preco_max;
    $param_types .= 'd';
}

$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(['erro' => 'Erro na preparação da query.']);
    exit;
}

if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    echo json_encode(['erro' => 'Erro ao executar a consulta.']);
    exit;
}

$produtos = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($produtos);
?>
X

