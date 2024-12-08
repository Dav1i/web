<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apagar Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <h1>Apagar Item</h1>

    <?php
        $servidor = 'localhost';
        $banco = 'produtos';
        $usuario = 'root';
        $senha = '';

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Sanitiza o ID para garantir que seja um número válido
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

            if ($id) {
                try {
                    // Conexão com o banco de dados
                    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
                    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Comando SQL para deletar o produto
                    $comandoSQL = "DELETE FROM produto WHERE id = :id";
                    $comando = $conexao->prepare($comandoSQL);

                    // Executa o comando
                    $resultado = $comando->execute(['id' => $id]);

                    if ($resultado) {
                        echo "<p>Produto apagado com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao apagar o produto. O ID fornecido pode não existir.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Erro ao conectar ao banco de dados: {$e->getMessage()}</p>";
                }

                // Fechar a conexão
                $conexao = null;
            } else {
                echo "<p>ID inválido fornecido.</p>";
            }
        } else {
            echo "<p>ID não especificado.</p>";
        }
    ?>

    <br>
    <a href="ProdMostrar.php">Voltar</a>
</body>
</html>
