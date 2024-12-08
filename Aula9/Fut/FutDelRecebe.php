<?php
// Configurações do banco de dados
$config = [
    'host' => 'localhost',
    'dbname' => 'futebol',
    'user' => 'root',
    'password' => ''
];

try {
    // Estabelece a conexão com o banco de dados
    $conexao = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['user'],
        $config['password']
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtém e valida o ID
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        // Prepara e executa o comando para deletar o time
        $query = 'DELETE FROM times WHERE id = :id';
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p>Time com ID $id deletado com sucesso.</p>";
        } else {
            echo "<p>Erro ao tentar deletar o time.</p>";
        }
    } else {
        echo "<p>ID do time não fornecido ou inválido.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
} finally {
    // Fecha a conexão
    $conexao = null;
}
?>

<!-- Link para voltar -->
<p><a href="FutMostrar.php">Voltar</a></p>
