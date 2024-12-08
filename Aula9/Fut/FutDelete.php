<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Apagar Item</h1>

    <?php
    // Configuração do banco de dados
    $config = [
        'host' => 'localhost',
        'dbname' => 'futebol',
        'user' => 'root',
        'password' => ''
    ];

    // Obtém o ID do item via GET
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        try {
            // Conexão com o banco de dados
            $conexao = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['user'],
                $config['password']
            );
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepara e executa o comando SQL para deletar o item
            $query = "DELETE FROM times WHERE id = :id";
            $stmt = $conexao->prepare($query);

            if ($stmt->execute(['id' => $id])) {
                echo "<p>Item apagado com sucesso!</p>";
            } else {
                echo "<p>Erro ao apagar o item.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
        } finally {
            // Fecha a conexão com o banco
            $conexao = null;
        }
    } else {
        echo "<p>ID não especificado ou inválido.</p>";
    }
    ?>

    <br>
    <a href="FutMostrar.php">Voltar</a>
</body>
</html>
