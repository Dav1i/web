<?php
$servidor = 'localhost';
$banco = 'produtos';
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
    <title>Atualizar Produto</title>
</head>
<body>
    <h1>Atualização de Produto</h1>
    
    <?php
    $id = $_GET['id'] ?? null;

    if ($id) {
        $comandoSQL = "SELECT `nome`, `url`, `descricao`, `preco` FROM `produto` WHERE `id` = :id";
        $comando = $conexao->prepare($comandoSQL);
        $comando->execute(['id' => $id]);

        if ($linha = $comando->fetch()) {
    ?>
    <form action="ProdAtualiza.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($linha['nome']) ?>" required><br>
        
        <label for="url">URL:</label>
        <input type="url" name="url" value="<?= htmlspecialchars($linha['url']) ?>" required><br>
        
        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" value="<?= htmlspecialchars($linha['descricao']) ?>" required><br>
        
        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($linha['preco']) ?>" required><br>
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <input type="submit" value="Atualizar">
    </form>
    <?php
        } else {
            echo "<p>Produto não encontrado.</p>";
        }
    } else {
    ?>
    <form action="ProdDados.php" method="GET">
        <label for="id">ID do Produto que será atualizado:</label>
        <input type="number" name="id" required><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
    }
    ?>
</body>
</html>
