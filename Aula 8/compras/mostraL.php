<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrando Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 300px;
        }
        .card h3 {
            margin: 0 0 10px;
        }
        .card p {
            margin: 5px 0;
        }
        .card a {
            display: inline-block;
            margin-top: 10px;
            color: white;
            background: #e74c3c;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        .card a:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $servidor = 'localhost';
        $banco = 'loja';
        $usuario = 'root';
        $senha = '';
        
        try {
            $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
            $comandoSQL = 'SELECT * FROM `produto`';
            $comando = $conexao->prepare($comandoSQL);
            $resultado = $comando->execute();

            if ($resultado) {
                while ($linha = $comando->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='card'>";
                    echo "<h3>" . htmlspecialchars($linha['nome']) . "</h3>";
                    echo "<img src='" . htmlspecialchars($linha['url']) . "' alt='" . htmlspecialchars($linha['nome']) . "' style='width:100%; border-radius: 10px;'>";
                    echo "<p>" . htmlspecialchars($linha['descricao']) . "</p>";
                    echo "<p>Preço: R$ " . htmlspecialchars($linha['preco']) . "</p>";
                    $id = $linha['id'];
                    echo "<a href='apaga.php?id=$id'>Apagar</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Erro no comando SQL</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erro na conexão: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</body>
</html>
