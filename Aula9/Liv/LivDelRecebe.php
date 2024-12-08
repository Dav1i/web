<?php
$servidor = 'localhost';
$banco = 'livros';
$usuario = 'root';
$senha = '';

try {
    // Conexão com o banco de dados
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o ID foi passado e se é um número válido
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int)$_GET['id']; // Converte o id para inteiro para maior segurança

        // Prepara a consulta para deletar o livro
        $comandoSQL = 'DELETE FROM livro WHERE ID = :id';
        $comando = $conexao->prepare($comandoSQL);
        $comando->bindParam(':id', $id, PDO::PARAM_INT);
        $comando->execute();

        // Verifica se alguma linha foi afetada pela exclusão
        if ($comando->rowCount() > 0) {
            echo "<p>Livro com ID $id deletado com sucesso.</p>";
        } else {
            echo "<p>Erro: Nenhum livro encontrado com o ID $id. Pode ser que ele já tenha sido excluído.</p>";
        }
    } else {
        echo "<p>ID do livro não fornecido ou é inválido.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Erro ao conectar ao banco de dados: {$e->getMessage()}</p>";
}

// Fechar a conexão
$conexao = null;
?>
<p><a href="livMostrar.php">Voltar</a></p> <!-- Link para voltar -->
