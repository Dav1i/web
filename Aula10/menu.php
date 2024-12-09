<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Notas</title>
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
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        a {
            text-decoration: none;
            color: #0056b3;
            text-align: center;
            padding: 10px;
            border: 1px solid #0056b3;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sistema de Notas</h1>
        <nav>
            <a href="Cadastro_Turma.php">Cadastrar Turma</a>
            <a href="Cadastro_Alunos.php">Cadastrar Aluno</a>
            <a href="Cadastro_Notas.php">Cadastrar Nota</a>
            <a href="Listar_Alunos.php">Listar Alunos</a>
        </nav>
    </div>
</body>
</html>
