<?php
session_start();
include('hospital.php'); // Conecta com o banco de dados

// Função para cadastrar médico ou enfermeiro
function cadastrar_usuario($nome, $usuario, $senha, $tipo, $crm_ou_coren, $especialidade = null) {
    global $conn;
    
    // Criptografar a senha
    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
    
    try {
        if ($tipo == 'medico') {
            // Cadastro de médico
            $sql = "INSERT INTO medicos (nome, usuario, senha, crm, especialidade) 
                    VALUES (:nome, :usuario, :senha, :crm, :especialidade)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':crm', $crm_ou_coren);
            $stmt->bindParam(':especialidade', $especialidade);
        } else {
            // Cadastro de enfermeiro
            $sql = "INSERT INTO enfermeiros (nome, usuario, senha, coren) 
                    VALUES (:nome, :usuario, :senha, :coren)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':coren', $crm_ou_coren);
        }

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha_criptografada);
        $stmt->execute();
        
        return "Cadastro realizado com sucesso!";
    } catch (PDOException $e) {
        return "Erro ao cadastrar: " . $e->getMessage();
    }
}

// Processamento do cadastro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $crm_ou_coren = $_POST['crm_ou_coren'];

    $especialidade = null;
    if ($tipo == 'medico') {
        $especialidade = $_POST['especialidade']; // Adiciona a especialidade para médicos
    }

    $mensagem = cadastrar_usuario($nome, $usuario, $senha, $tipo, $crm_ou_coren, $especialidade);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepção - Cadastro e Login</title>
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
        input[type="text"], input[type="password"], input[type="submit"], select {
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
        .form-section {
            margin-top: 30px;
        }
        .form-section h2 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Mensagem de sucesso ou erro -->
    <?php if (isset($mensagem)): ?>
        <div class="error"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <!-- Formulário de Cadastro -->
    <div class="form-section">
        <h2>Cadastro</h2>
        <form method="POST" action="recepcao.php">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="usuario">Usuário</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo de Usuário</label>
                <select id="tipo" name="tipo" required onchange="exibirCampos()">
                    <option value="medico">Médico</option>
                    <option value="enfermeiro">Enfermeiro</option>
                </select>
            </div>

            <!-- Campos para Médico -->
            <div id="campos_medico" style="display: none;">
                <div class="form-group">
                    <label for="crm_ou_coren">CRM (somente para médicos)</label>
                    <input type="text" id="crm_ou_coren" name="crm_ou_coren" required>
                </div>
                <div class="form-group">
                    <label for="especialidade">Especialidade (somente para médicos)</label>
                    <input type="text" id="especialidade" name="especialidade" required>
                </div>
            </div>

            <!-- Campos para Enfermeiro -->
            <div id="campos_enfermeiro" style="display: none;">
                <div class="form-group">
                    <label for="crm_ou_coren">COREN (somente para enfermeiros)</label>
                    <input type="text" id="crm_ou_coren" name="crm_ou_coren" required>
                </div>
            </div>

            <div class="form-group">
                <input type="submit" name="cadastrar" value="Cadastrar">
            </div>
        </form>

        <!-- Link para Login se o usuário já tiver cadastro -->
        <p>Já tem um cadastro? <a href="login.php">Clique aqui para fazer login</a></p>
    </div>

</div>

<script>
    // Função para exibir campos dependendo do tipo de usuário (Médico ou Enfermeiro)
    function exibirCampos() {
        var tipo = document.getElementById('tipo').value;
        if (tipo == 'medico') {
            document.getElementById('campos_medico').style.display = 'block';
            document.getElementById('campos_enfermeiro').style.display = 'none';
        } else {
            document.getElementById('campos_enfermeiro').style.display = 'block';
            document.getElementById('campos_medico').style.display = 'none';
        }
    }

    // Chama a função para exibir os campos corretos ao carregar a página
    exibirCampos();
</script>

</body>
</html>
