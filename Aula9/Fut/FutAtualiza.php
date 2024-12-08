<?php
// Configurações do banco de dados
$config = [
    'host' => 'localhost',
    'dbname' => 'futebol',
    'user' => 'root',
    'password' => ''
];

try {
    // Estabelecendo conexão com o banco de dados
    $conexao = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['user'],
        $config['password']
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validação dos dados recebidos via GET
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $nome = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);
    $pontos = filter_input(INPUT_GET, 'pontos', FILTER_VALIDATE_INT);

    if ($id && $nome && $pontos !== false) {
        // Atualização do time
        $codigoSQL = "UPDATE `times` SET `nome` = :nome, `pontos` = :pontos WHERE `id` = :id";
        $comando = $conexao->prepare($codigoSQL);

        $resultado = $comando->execute([
            ':nome' => $nome,
            ':pontos' => $pontos,
            ':id' => $id
        ]);

        echo $resultado ? "<p>Time atualizado com sucesso!</p>" : "<p>Erro ao atualizar o time.</p>";
    } else {
        echo "<p>Dados inválidos ou incompletos fornecidos.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
} finally {
    $conexao = null; // Fechar a conexão
}
?>

