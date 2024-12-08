<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrando Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #0FF;
            text-align: left;
        }
        th {
            background-color: #FF00FF;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
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
    <h1>Mostrando Resultados dos Times</h1>

    <?php
    // Configurações do banco de dados
    $config = [
        'host' => 'localhost',
        'dbname' => 'futebol',
        'user' => 'root',
        'password' => ''
    ];

    try {
        // Conexão com o banco de dados
        $conexao = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config['user'],
            $config['password']
        );
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta os times no banco
        $query = 'SELECT * FROM times';
        $stmt = $conexao->prepare($query);
        $stmt->execute();
        $times = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($times) {
            echo "<table>";
            echo "<thead><tr><th>Nome do Time</th><th>Pontos</th><th>Opções</th></tr></thead>";
            echo "<tbody>";

            foreach ($times as $time) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($time['Nome']) . "</td>";
                echo "<td>" . htmlspecialchars($time['Pontos']) . "</td>";
                echo "<td>
                        <a href='FutDelete.php?id=" . urlencode($time['ID']) . "'>Apagar</a> |
                        <a href='FutRecebeID.php?id=" . urlencode($time['ID']) . "'>Atualizar</a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>Nenhum time encontrado.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
    } finally {
        // Fecha a conexão
        $conexao = null;
    }
    ?>
</body>
</html>
