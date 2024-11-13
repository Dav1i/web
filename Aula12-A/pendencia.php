<?php
session_start();
include('hospital.php'); // Conectar ao banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Pega o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

// Verifica o tipo de usuário (enfermeiro)
$tipo_usuario = $_SESSION['tipo_usuario'];
if ($tipo_usuario != 'enfermeiro') {
    header("Location: painel.php"); // Redireciona se não for enfermeiro
    exit();
}

// Registrar administração de uma receita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['receita_id'])) {
    $receita_id = $_POST['receita_id'];
    $data_registro = $_POST['data_registro'];
    $hora_registro = $_POST['hora_registro'];
    
    try {
        // Insere a administração na tabela de administracoes
        $insert_sql = "INSERT INTO administracoes (receita_id, enfermeiro_id, data_registro, hora_registro) 
                       VALUES (:receita_id, :enfermeiro_id, :data_registro, :hora_registro)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bindParam(':receita_id', $receita_id);
        $stmt->bindParam(':enfermeiro_id', $usuario_id);
        $stmt->bindParam(':data_registro', $data_registro);
        $stmt->bindParam(':hora_registro', $hora_registro);
        $stmt->execute();

        // Redireciona para a lista de pendências
        header("Location: pendencia.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao registrar a administração: " . $e->getMessage();
    }
}

// Consulta para pegar todas as receitas pendentes
try {
    // A consulta agora traz as receitas que NÃO possuem registros na tabela de administracoes
    $sql = "SELECT r.id, r.paciente_id, r.nome_medicamento, r.data_administracao, r.hora_administracao, r.dose, 
                   p.nome AS paciente_nome, p.leito
            FROM receitas r
            JOIN pacientes p ON r.paciente_id = p.id
            LEFT JOIN administracoes a ON r.id = a.receita_id
            WHERE a.receita_id IS NULL";  // Filtra receitas que ainda não foram administradas
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($receitas)) {
        $mensagem = "Não há receitas pendentes para administração.";
    }
} catch (PDOException $e) {
    echo "Erro ao carregar as receitas: " . $e->getMessage();
}
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
