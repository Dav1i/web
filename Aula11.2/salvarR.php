<?php
session_start();
include('hospital.php'); // Conectar ao banco de dados

// Verifica se o usuário está logado e se é um médico
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 'medico') {
    // Se não estiver logado ou não for médico, redireciona para o login
    header("Location: login.php");
    exit();
}

// Pega o ID do médico da sessão
$medico_id = $_SESSION['usuario_id'];

// Inicializa variáveis para mensagens de erro ou sucesso
$erro = '';
$sucesso = '';

// Verifica se os dados do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $paciente_id = $_POST['paciente_id'];
    $nome_medicamento = $_POST['nome_medicamento'];
    $data_administracao = $_POST['data_administracao'];
    $hora_administracao = $_POST['hora_administracao'];
    $dose = $_POST['dose'];

    // Validação básica dos dados
    if (empty($paciente_id) || empty($nome_medicamento) || empty($data_administracao) || empty($hora_administracao) || empty($dose)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } else {
        try {
            // Prepara a consulta para inserir a receita na tabela 'receitas'
            $sql = "INSERT INTO receitas (paciente_id, nome_medicamento, data_administracao, hora_administracao, dose) 
                    VALUES (:paciente_id, :nome_medicamento, :data_administracao, :hora_administracao, :dose)";
            $stmt = $conn->prepare($sql);

            // Liga os parâmetros
            $stmt->bindParam(':paciente_id', $paciente_id);
            $stmt->bindParam(':nome_medicamento', $nome_medicamento);
            $stmt->bindParam(':data_administracao', $data_administracao);
            $stmt->bindParam(':hora_administracao', $hora_administracao);
            $stmt->bindParam(':dose', $dose);

            // Executa a consulta
            $stmt->execute();

            // Se a inserção for bem-sucedida, exibe uma mensagem de sucesso
            $sucesso = 'Prescrição registrada com sucesso!';

            // Redireciona para o painel do médico após salvar a receita
            header("Location: painelM.php");
            exit();
        } catch (PDOException $e) {
            // Se houver erro, exibe a mensagem de erro
            $erro = 'Erro ao registrar a prescrição: ' . $e->getMessage();
        }
    }
}

?>

<!-- Página de retorno para erros ou mensagens de sucesso -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Prescrição</title>
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
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .error {
            background-color: #f44336;
            color: white;
        }
        .success {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Resultado da Prescrição</h1>

    <!-- Mensagem de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="message error"><?php echo $erro; ?></div>
    <?php elseif ($sucesso): ?>
        <div class="message success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 20px;">
        <a href="painelM.php">Voltar para o painel</a>
    </div>
</div>

</body>
</html>
