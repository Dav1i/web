<?php 
include 'conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Alunos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        a {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-size: 1rem;
            transition: color 0.3s;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Listar Alunos de uma Turma</h2>
        <form action="Listar_Alunos_result.php" method="GET">
            <label for="id_turma">Selecionar Turma:</label>
            <select id="id_turma" name="id_turma" required>
                <option value="" disabled selected>Selecione uma turma</option>
                <?php
                // Consultar as turmas disponíveis no banco de dados
                $turmas = $pdo->query("SELECT id, nome FROM turmas")->fetchAll();
                foreach ($turmas as $turma) {
                    echo "<option value='{$turma['id']}'>{$turma['nome']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Listar Alunos">
        </form>
        <a href="menu.php">Voltar</a>
    </div>
</body>
</html>
