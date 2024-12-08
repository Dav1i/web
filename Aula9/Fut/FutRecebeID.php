<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recebe ID do Time</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="submit"] {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Recebe ID do Time</h1>

    <?php
    // Verifica se o ID foi passado via GET
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($id) {
    ?>
        <form action="FutDados.php" method="GET">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label>ID do Time que será atualizado: <?php echo $id; ?></label><br>
            <input type="submit" value="Enviar">
        </form>
    <?php
    } else {
        echo "<p>ID do time não fornecido ou inválido.</p>";
    }
    ?>

    <p><a href="FutMostrar.php">Voltar</a></p> <!-- Link para voltar -->
</body>
</html>
