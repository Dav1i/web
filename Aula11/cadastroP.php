<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Paciente</title>
</head>
<body>
    <h1>Cadastro de Paciente</h1>
    <form action="salvaP.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="especialidade">Especialidade:</label>
        <input type="text" name="especialidade" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
