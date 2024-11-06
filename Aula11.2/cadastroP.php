<?php
session_start();
include('hospital.php'); // Conectar ao banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o usuário é um médico ou outro tipo de usuário autorizado
if ($_SESSION['tipo_usuario'] != 'medico') {
    // Se não for médico, redireciona para página inicial ou página de erro
    header("Location: login.php");
    exit();
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = trim($_POST['nome']);
    $leito = trim($_POST['leito']);
    
    // Validação básica
    if (empty($nome) || empty($leito)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } else {
        try {
            // Prepara a consulta para inserir o paciente no banco de dados
            $sql = "INSERT INTO pacientes (nome, leito) VALUES (:nome, :leito)";
            $stmt = $conn->prepare($sql);

            // Liga os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':leito', $leito);

            // Executa a consulta
            $stmt->execute();

            // Exibe mensagem de sucesso
            $sucesso = 'Paciente cadastrado com sucesso!';
        } catch (PDOException $e) {
            $erro = 'Erro ao cadastrar paciente: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
    <h1>Cadastro de Paciente</h1>

    <!-- Mensagem de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="message error"><?php echo $erro; ?></div>
    <?php endif; ?>
    <?php if ($sucesso): ?>
        <div class="message success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <form method="GET" action="salvarP.php">
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>" required>

        <label for="leito">Leito:</label>
        <input type="text" id="leito" name="leito" value="<?php echo isset($leito) ? htmlspecialchars($leito) : ''; ?>" required>

       
        <input type="submit" value="Cadastrar Paciente">
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="login.php">Voltar para a página inicial</a>
    </div>
</div>

</body>
</html>
