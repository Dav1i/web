<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Médicos</title>
</head>
<body>
    <h1>Cadastro de Médicos</h1>
    <form action="salvaM.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>

        <label for="especialidade">Especialidade:</label>
        <input type="text" name="especialidade" required><br>

        <label for="crm">CRM:</label>
        <input type="text" name="crm" required><br>

        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
