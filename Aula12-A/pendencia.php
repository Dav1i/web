<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$conn = mysqli_connect("localhost", "root", "", "hospital");
if (!$conn) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
}

$sql = "SELECT * FROM receitas WHERE status = 'pendente'";
$result = mysqli_query($conn, $sql);

$pendencias = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pendencias[] = $row;
}

echo json_encode($pendencias);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas Pendentes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            font-size: 18px;
            color: #555;
        }
        .receitas-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .receitas-table th, .receitas-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .receitas-table th {
            background-color: #f4f4f4;
        }
        .logout {
            margin-top: 20px;
            text-align: center;
        }
        .logout a {
            text-decoration: none;
            color: white;
            background-color: #f44336;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .logout a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Receitas Pendentes</h1>

    <!-- Mensagem caso não haja receitas -->
    <?php if (isset($mensagem)): ?>
        <div class="error"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <!-- Exibe todas as receitas pendentes -->
    <?php if (!empty($receitas)): ?>
        <table class="receitas-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Medicamento</th>
                    <th>Data de Administração</th>
                    <th>Hora de Administração</th>
                    <th>Dose</th>
                    <th>Leito</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receitas as $receita): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($receita['id']); ?></td>
                        <td><?php echo htmlspecialchars($receita['paciente_nome']); ?></td>
                        <td><?php echo htmlspecialchars($receita['nome_medicamento']); ?></td>
                        <td><?php echo htmlspecialchars($receita['data_administracao']); ?></td>
                        <td><?php echo htmlspecialchars($receita['hora_administracao']); ?></td>
                        <td><?php echo htmlspecialchars($receita['dose']); ?></td>
                        <td><?php echo htmlspecialchars($receita['leito']); ?></td>
                        <td><a href="pendencia.php?receita_id=<?php echo $receita['id']; ?>">Registrar Administração</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Formulário para registrar a administração -->
    <?php if (isset($_GET['receita_id'])): ?>
        <h2>Registrar Administração</h2>
        <form method="POST" action="pendencia.php">
            <input type="hidden" name="receita_id" value="<?php echo $_GET['receita_id']; ?>">
            <div>
                <label for="data_registro">Data de Registro:</label>
                <input type="date" id="data_registro" name="data_registro" required>
            </div>
            <div>
                <label for="hora_registro">Hora de Registro:</label>
                <input type="time" id="hora_registro" name="hora_registro" required>
            </div>
            <div>
                <input type="submit" value="Registrar Administração">
            </div>
        </form>
    <?php endif; ?>

    <!-- Botão de logout -->
    <div class="logout">
        <a href="painelEn.php">Sair</a>
    </div>
</div>

</body>
</html>
