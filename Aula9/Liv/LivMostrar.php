<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrando Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #0FF;
        }
        th {
            background-color: #FF00FF;
        }
        a {
            color: #d9534f;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message, .success-message {
            color: red;
            font-weight: bold;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Mostrando Resultados</h1>

    <?php
        $servidor = 'localhost';
        $banco = 'livros';
        $usuario = 'root';
        $senha = '';

        try {
            // Conexão com o banco de dados
            $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Comando SQL para buscar os dados
            $comandoSQL = 'SELECT * FROM livro';
            $comando = $conexao->prepare($comandoSQL);
            $comando->execute();

            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

            if ($resultado) {
                echo "<table>";
                echo "<thead><tr><th>Título</th><th>Idioma</th><th>Qtd Páginas</th><th>Editora</th><th>Data de Publicação</th><th>ISBN</th><th>Opções</th></tr></thead>";
                echo "<tbody>";

                foreach ($resultado as $linha) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($linha['Titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['Idioma']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['qtdPaginas']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['Editora']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['dataPublicacao']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['ISBN']) . "</td>";
                    echo "<td>
                            <a href='LivDelRecebe.php?id=" . htmlspecialchars($linha['ID']) . "'>Apagar</a> |
                            <a href='LivRecebeID.php?id=" . htmlspecialchars($linha['ID']) . "'>Atualizar</a>
                          </td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>Nenhum livro encontrado.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='error-message'>Erro ao conectar ao banco de dados: {$e->getMessage()}</p>";
        }

        // Fechar a conexão
        $conexao = null;
    ?>

</body>
</html>
