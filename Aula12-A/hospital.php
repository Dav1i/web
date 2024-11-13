<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

try {
    // Criar a conexão usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Definir o modo de erro do PDO para exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: Definir charset para evitar problemas com acentuação
    $conn->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    // Em caso de erro, exibe a mensagem e termina o script
    die("Falha na conexão: " . $e->getMessage());
}
?>
