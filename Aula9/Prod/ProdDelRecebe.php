<?php
$servidor = 'localhost';
$banco = 'Produtos';
$usuario = 'root';
$senha = '';

try {
    // Conexão com o banco de dados
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o ID foi passado e é válido
    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
        $id = (int)$_GET['id']; // Garante que o ID seja um número inteiro

        // Prepara a consulta para deletar o produto
        $comandoSQL = 'DELETE FROM produto WHERE ID = :id';
        $comando = $conexao->prepare($comandoSQL);
        $comando->bindParam(':id', $id, PDO::PARAM_INT);

        if ($comando->execute()) {
            echo "<p>Produto com ID $id deletado com sucesso.</p>";
        } else {
            echo "<p>Erro ao tentar apagar o produto. Verifique o ID.</p>";
        }
    } else {
        echo "<p>ID inválido ou não fornecido.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Erro ao conectar ao banco de dados: {$e->getMessage()}</p>";
} finally {
    // Fechar a conexão
    $conexao = null;
}
?>

<p><a href="ProdMostrar.php">Voltar</a></p> <!-- Link para voltar -->
