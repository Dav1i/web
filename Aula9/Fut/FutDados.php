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
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Time</title>
</head>
<body>
    <h1>Atualização de Time</h1>

    <?php
    // Obtém o ID do time via GET
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        // Consulta o time pelo ID
        $query = "SELECT `nome`, `pontos` FROM `times` WHERE `id` = :id";
        $stmt = $conexao->prepare($query);
        $stmt->execute(['id' => $id]);

        // Verifica se o time foi encontrado
        if ($time = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="FutAtualiza.php" method="GET">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($time['nome']) ?>" required><br>
        
        <label for="pontos">Pontos:</label>
        <input type="number" name="pontos" id="pontos" value="<?= htmlspecialchars($time['pontos']) ?>" required><br>
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <button type="submit">Atualizar</button>
    </form>
    <?php
        } else {
            echo "<p>Time não encontrado.</p>";
        }
    } else {
    ?>
    <form action="FutDados.php" method="GET">
        <label for="id">ID do Time que será atualizado:</label>
        <input type="number" name="id" id="id" required><br>
        <button type="submit">Enviar</button>
    </form>
    <?php
    }
    ?>
</body>
</html>
