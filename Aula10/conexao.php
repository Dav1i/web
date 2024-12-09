<?php
$servidor = 'localhost';
$banco = 'sistema_notas';
$usuario = 'root';
$senha = '';

try {
    // Criar a conexão com o banco de dados
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    
    // Configurar o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Caso a conexão seja bem-sucedida
    echo "Conexão estabelecida com sucesso!";
} catch (PDOException $e) {
    // Captura e exibe qualquer erro durante a conexão
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
