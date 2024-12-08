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
    </style>
</head>
<body>
    <h1>Mostrando Resultados</h1>

    <?php
        $servidor = 'localhost';
        $banco = 'produtos';
        $usuario = 'root';
        $senha = '';

        try {
            // Conexão com o banco de dados
            $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Comando SQL para buscar os dados
            $comandoSQL = 'SELECT * FROM produto';
            $comando = $conexao->prepare($comandoSQL);
            $comando->execute();

            $resultado = $comando->fetchAll(PDO::FETCH_ASSOC);

            if ($resultado) {
                echo "<table>";
                echo "<thead><tr><th>Nome</th><th>Url</th><th>Descrição</th><th>Preço</th><th>Opções</th></tr></thead>";
                echo "<tbody>";

                foreach ($resultado as $linha) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($linha['Nome']) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($linha['Url']) . "'>Link</a></td>";
                    echo "<td>" . htmlspecialchars($linha['Descricao']) . "</td>";
                    echo "<td>R$ " . number_format(htmlspecialchars($linha['preco']), 2, ',', '.') . "</td>";
                    echo "<td>
                            <a href='ProdDelRecebe.php?id=" . htmlspecialchars($linha['ID']) . "'>Apagar</a> |
                            <a href='ProdRecebeID.php?id=" . htmlspecialchars($linha['ID']) . "'>Atualizar</a>
                          </td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p>Nenhum produto encontrado.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao conectar ao banco de dados: {$e->getMessage()}</p>";
        }

        // Fechar a conexão
        $conexao = null;
    ?>

</body>
</html>
