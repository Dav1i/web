<?php
$servidor = 'localhost';
$banco = 'livros';
$usuario = 'root';
$senha = '';

try {
    // Conexão com o banco de dados
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Livro</title>
</head>
<body>
    <h1>Atualização de Livro</h1>
    
    <?php
    // Verifica se o ID foi passado via GET e valida
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        // Prepara a consulta para pegar os dados do livro com o ID fornecido
        $comandoSQL = "SELECT `titulo`, `idioma`, `qtdPaginas`, `editora`, `dataPublicacao`, `ISBN` FROM `livro` WHERE `id` = :id";
        $comando = $conexao->prepare($comandoSQL);
        $comando->bindParam(':id', $id, PDO::PARAM_INT);
        $comando->execute();

        // Verifica se o livro foi encontrado
        if ($linha = $comando->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="LivAtualiza.php" method="GET">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($linha['titulo']) ?>" required><br>
        
        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" value="<?= htmlspecialchars($linha['idioma']) ?>" required><br>
        
        <label for="qtdPaginas">Quantidade de Páginas:</label>
        <input type="number" name="qtdPaginas" value="<?= htmlspecialchars($linha['qtdPaginas']) ?>" required><br>
        
        <label for="editora">Editora:</label>
        <input type="text" name="editora" value="<?= htmlspecialchars($linha['editora']) ?>" required><br>
        
        <label for="dataPublicacao">Data de Publicação:</label>
        <input type="date" name="dataPublicacao" value="<?= htmlspecialchars($linha['dataPublicacao']) ?>" required><br>
        
        <label for="ISBN">ISBN:</label>
        <input type="text" name="ISBN" value="<?= htmlspecialchars($linha['ISBN']) ?>" required><br>
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <input type="submit" value="Atualizar">
    </form>
    <?php
        } else {
            echo "<p>Livro não encontrado. Por favor, verifique o ID e tente novamente.</p>";
        }
    } else {
    ?>
    <form action="LivDados.php" method="GET">
        <label for="id">ID do Livro que será atualizado:</label>
        <input type="text" name="id" required><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
    }
    ?>
</body>
</html>
