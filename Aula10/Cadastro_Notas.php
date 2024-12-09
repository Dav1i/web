<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="number"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 1.1rem;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Notas</h2>
        <form action="Inserir_Notas.php" method="POST">
            <div class="form-group">
                <label for="valor">Inserir Nota:</label>
                <input type="number" id="valor" name="valor" min="0" max="100" step="0.01" required placeholder="Digite a nota (0 a 100)">
            </div>

            <div class="form-group">
                <label for="id_aluno">Escolha um Aluno:</label>
                <select name="id_aluno" id="id_aluno" required>
                    <optgroup label="Alunos">
                        <?php
                        include 'conexao.php';
                        $Alunos = $pdo->query("SELECT * FROM alunos")->fetchAll();
                        foreach ($Alunos as $Aluno) {
                            echo "<option value='{$Aluno['id']}'>{$Aluno['nome']}</option>";
                        }
                        ?>
                    </optgroup>
                </select>
            </div>

            <input type="submit" value="Cadastrar Nota">
        </form>
        <a href="menu.php">Voltar ao menu principal</a>
    </div>
</body>
</html>
