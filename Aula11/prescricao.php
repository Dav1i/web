<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Prescrição de Medicamentos</title>
</head>
<body>
    <h1>Prescrição de Medicamentos</h1>
    <form action="salvaRP.php" method="post">
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

        <input type="submit" value="Prescrever">
    </form>
</body>
</html>
