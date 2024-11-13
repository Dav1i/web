<?php
session_start();
include('hospital.php'); // Conectar ao banco de dados

// Verifica se o médico está logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 'medico') {
    // Se não estiver logado como médico, redireciona para o login
    header("Location: login.php");
    exit();
}

// Pega o ID do médico da sessão
$medico_id = $_SESSION['usuario_id'];

try {
    // Prepara a consulta para buscar as informações do médico
    $sql = "SELECT nome, crm, especialidade FROM medicos WHERE id = :medico_id";
    
    // Prepara a consulta PDO
    $stmt = $conn->prepare($sql);
    
    // Liga o parâmetro
    $stmt->bindParam(':medico_id', $medico_id);
    
    // Executa a consulta
    $stmt->execute();
    
    // Recupera os dados do médico
    $medico = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$medico) {
        // Se não encontrar o médico, redireciona para a página de login
        header("Location: login.php");
        exit();
    }

} catch (PDOException $e) {
    echo "Erro ao carregar o painel: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Médico</title>
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
        .actions {
            margin-top: 30px;
        }
        .actions h3 {
            color: #333;
        }
        .actions ul {
            list-style-type: none;
            padding: 0;
        }
        .actions ul li {
            margin: 10px 0;
        }
        .actions ul li a {
            text-decoration: none;
            color: #007bff;
        }
        .actions ul li a:hover {
            text-decoration: underline;
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
    <h1>Bem-vindo ao Painel, <?php echo htmlspecialchars($medico['nome']); ?>!</h1>
    <div class="info">
        <p><strong>CRM:</strong> <?php echo htmlspecialchars($medico['crm']); ?></p>
        <p><strong>Especialidade:</strong> <?php echo htmlspecialchars($medico['especialidade']); ?></p>
    </div>

    <!-- Ações do médico -->
    <div class="actions">
        <h3>O que você deseja fazer?</h3>
        <ul>
            <li><a href="cadastroP.php">Registar paciente</a></li>
            <li><a href="pendencia.php">Ver pendencias</a></li>
            <li><a href="cadastroR.php">Prescrever medicamentos</a></li>
        </ul>
    </div>

    <!-- Botão de logout -->
    <div class="logout">
        <a href="logout.php">Sair</a>
    </div>
</div>

</body>
</html>
