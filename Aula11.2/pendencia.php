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

// Verifica o tipo de usuário (médico ou enfermeiro)
$tipo_usuario = $_SESSION['tipo_usuario'];

// Verifica o tipo de usuário e a permissão de edição
if ($tipo_usuario != 'medico') {
    // Se não for médico, o enfermeiro só pode visualizar as receitas
    $permitir_edicao = false;
} else {
    // Se for médico, permite a edição das receitas
    $permitir_edicao = true;
}

// Pega o ID da receita (caso o usuário queira editar uma receita específica)
$receita_id = isset($_GET['receita_id']) ? $_GET['receita_id'] : null;

if ($receita_id) {
    try {
        // Prepara a consulta para buscar a receita com base no ID da receita
        $sql = "SELECT r.id, r.paciente_id, r.nome_medicamento, r.data_administracao, r.hora_administracao, r.dose, p.nome AS paciente_nome, r.medico_id
                FROM receitas r
                JOIN pacientes p ON r.paciente_id = p.id
                WHERE r.id = :receita_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':receita_id', $receita_id);
        $stmt->execute();
        $receita = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$receita) {
            // Se não encontrar a receita, ou a receita não for do médico logado, redireciona
            echo "Receita não encontrada ou não autorizada.";
            exit();
        }

        // Caso o médico queira editar, e ele tenha permissão para isso
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $permitir_edicao) {
            // Atualiza a receita no banco de dados
            $nome_medicamento = $_POST['nome_medicamento'];
            $data_administracao = $_POST['data_administracao'];
            $hora_administracao = $_POST['hora_administracao'];
            $dose = $_POST['dose'];

            $update_sql = "UPDATE receitas 
                           SET nome_medicamento = :nome_medicamento, 
                               data_administracao = :data_administracao, 
                               hora_administracao = :hora_administracao, 
                               dose = :dose 
                           WHERE id = :receita_id";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':nome_medicamento', $nome_medicamento);
            $update_stmt->bindParam(':data_administracao', $data_administracao);
            $update_stmt->bindParam(':hora_administracao', $hora_administracao);
            $update_stmt->bindParam(':dose', $dose);
            $update_stmt->bindParam(':receita_id', $receita_id);
            $update_stmt->execute();

            // Redireciona após salvar as alterações
            header("Location: pendencia.php");
            exit();
        }

    } catch (PDOException $e) {
        echo "Erro ao carregar a receita: " . $e->getMessage();
    }
} else {
    // Se não houver ID de receita, exibe todas as receitas do médico
    try {
        // Prepara a consulta para buscar todas as receitas do médico logado
        $sql = "SELECT r.id, r.paciente_id, r.nome_medicamento, r.data_administracao, r.hora_administracao, r.dose, p.nome AS paciente_nome 
                FROM receitas r 
                JOIN pacientes p ON r.paciente_id = p.id
                WHERE r.medico_id = :medico_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':medico_id', $usuario_id);
        $stmt->execute();
        $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($receitas)) {
            $mensagem = "Não há receitas registradas para este médico.";
        }
    } catch (PDOException $e) {
        echo "Erro ao carregar as receitas: " . $e->getMessage();
    }
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

    <!-- Se houver um ID de receita, permite edição para médicos -->
    <?php if ($receita_id): ?>
        <?php if ($permitir_edicao): ?>
            <h2>Editar Receita</h2>
            <form method="POST" action="pendencia.php?receita_id=<?php echo $receita_id; ?>">
                <div>
                    <label for="nome_medicamento">Nome do Medicamento:</label>
                    <input type="text" id="nome_medicamento" name="nome_medicamento" value="<?php echo htmlspecialchars($receita['nome_medicamento']); ?>" required>
                </div>
                <div>
                    <label for="data_administracao">Data de Administração:</label>
                    <input type="date" id="data_administracao" name="data_administracao" value="<?php echo htmlspecialchars($receita['data_administracao']); ?>" required>
                </div>
                <div>
                    <label for="hora_administracao">Hora de Administração:</label>
                    <input type="time" id="hora_administracao" name="hora_administracao" value="<?php echo htmlspecialchars($receita['hora_administracao']); ?>" required>
                </div>
                <div>
                    <label for="dose">Dose:</label>
                    <input type="text" id="dose" name="dose" value="<?php echo htmlspecialchars($receita['dose']); ?>" required>
                </div>
                <div>
                    <input type="submit" value="Salvar Alterações">
                </div>
            </form>
        <?php else: ?>
            <h2>Visualizar Receita</h2>
            <p><strong>Nome do Medicamento:</strong> <?php echo htmlspecialchars($receita['nome_medicamento']); ?></p>
            <p><strong>Data de Administração:</strong> <?php echo htmlspecialchars($receita['data_administracao']); ?></p>
            <p><strong>Hora de Administração:</strong> <?php echo htmlspecialchars($receita['hora_administracao']); ?></p>
            <p><strong>Dose:</strong> <?php echo htmlspecialchars($receita['dose']); ?></p>
        <?php endif; ?>
    <?php else: ?>
        <!-- Exibe todas as receitas do médico -->
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
                            <?php if ($permitir_edicao): ?>
                                <td><a href="pendencia.php?receita_id=<?php echo $receita['id']; ?>">Editar</a></td>
                            <?php else: ?>
                                <td>Visualizar</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Botão de logout -->
    <div class="logout">
        <a href="logout.php">Sair</a>
    </div>
</div>

</body>
</html>
