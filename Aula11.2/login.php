<?php
session_start();
include('hospital.php'); // Conectar ao banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    try {
        // Primeiro, tenta verificar se o usuário é um médico
        $sql_medico = "SELECT * FROM medicos WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql_medico);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $medico = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se for médico, verifica a senha
        if ($medico && password_verify($senha, $medico['senha'])) {
            $_SESSION['usuario_id'] = $medico['id'];
            $_SESSION['tipo_usuario'] = 'medico'; // Define o tipo como médico
            header("Location: painelM.php"); // Redireciona para o dashboard do médico
            exit();
        }

        // Se não for médico, tenta verificar se é um enfermeiro
        $sql_enfermeiro = "SELECT * FROM enfermeiros WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql_enfermeiro);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $enfermeiro = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se for enfermeiro, verifica a senha
        if ($enfermeiro && password_verify($senha, $enfermeiro['senha'])) {
            $_SESSION['usuario_id'] = $enfermeiro['id'];
            $_SESSION['tipo_usuario'] = 'enfermeiro'; // Define o tipo como enfermeiro
            header("Location: painelEn.php"); // Redireciona para o dashboard do enfermeiro
            exit();
        }

        // Se nenhum dos dois tipos de usuário for encontrado
        $erro_login = "Usuário ou senha inválidos.";

    } catch (PDOException $e) {
        $erro_login = "Erro ao verificar o login: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Recepção</title>
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
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            color: #555;
        }
        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Login</h1>

    <!-- Exibe erro de login, se houver -->
    <?php if (isset($erro_login)): ?>
        <div class="error"><?php echo $erro_login; ?></div>
    <?php endif; ?>

    <!-- Formulário de Login -->
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Entrar">
        </div>
    </form>
</div>

</body>
</html>

