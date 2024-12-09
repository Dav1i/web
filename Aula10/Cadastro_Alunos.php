<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            margin-bottom: 5px;
            display: inline-block;
        }
        input[type="text"],
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastro de Alunos</h2>
        <form action="Inserir_Alunos.php" method="POST">
            <label for="nome">Nome do Aluno:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="id_turma">Escolha uma Turma:</label>
            <select id="id_turma" name="id_turma" required>
                <optgroup label="Turmas">
                    <?php
                    include 'conexao.php';
                    $query = $pdo->query("SELECT * FROM turmas");
                    foreach ($query as $turma) {
                        echo "<option value=\"{$turma['id']}\">{$turma['nome']}</option>";
                    }
                    ?>
                </optgroup>
            </select>

            <button type="submit">Cadastrar Aluno</button>
        </form>
        <a class="back-link" href="menu.php">Voltar</a>
    </div>
</body>
</html>
