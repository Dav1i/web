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
        $banco = 'livros';
        $usuario = 'root';
        $senha = '';

        // Verifica se o ID foi passado e se é um número válido
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = (int)$_GET['id']; // Converte o id para inteiro para segurança

            try {
                // Conexão com o banco de dados
                $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Comando SQL para deletar o item
                $comandoSQL = "DELETE FROM livro WHERE id = :id";
                $comando = $conexao->prepare($comandoSQL);

                // Executa o comando
                $resultado = $comando->execute(['id' => $id]);

                if ($resultado) {
                    echo "<p>Item apagado com sucesso!</p>";
                } else {
                    echo "<p>Erro ao apagar o item. O item pode não existir.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Erro ao conectar ao banco de dados: {$e->getMessage()}</p>";
            } catch (Exception $e) {
                echo "<p>Erro inesperado: {$e->getMessage()}</p>";
            }

            // Fechar a conexão
            $conexao = null;
        } else {
            echo "<p>ID não especificado ou inválido. Por favor, forneça um ID válido.</p>";
        }
    ?>

    <br>
    <a href="LivMostrar.php">Voltar</a>
</body>
</html>
