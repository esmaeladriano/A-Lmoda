<?php
// Configurações para conexão com o banco de dados
$servername = "localhost"; // ou o IP do seu servidor MySQL
$username = "root"; // Usuário do MySQL
$password = ""; // Senha do MySQL
$dbname = "loja_online"; // Nome da base de dados

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
