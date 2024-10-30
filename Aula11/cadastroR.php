<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Receita</title>
</head>
<body>
    <h1>Cadastro de Receita Médica</h1>
    <form action="salvarR.php" method="post">
        <label for="nome_paciente">Nome do Paciente:</label>
        <input type="text" name="nome_paciente" required><br>

        <label for="nome_medicamento">Nome do Medicamento:</label>
        <input type="text" name="nome_medicamento" required><br>

        <label for="data_administracao">Data da Administração:</label>
        <input type="date" name="data_administracao" required><br>

        <label for="hora_administracao">Hora da Administração:</label>
        <input type="time" name="hora_administracao" required><br>

        <label for="dose">Dose:</label>
        <input type="text" name="dose" required><br>

        <input type="submit" value="Cadastrar Receita">
    </form>
</body>
</html>
