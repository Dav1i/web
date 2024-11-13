<?php
// Inclui o arquivo de conexão com o banco
include('hospital.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $crm = $_POST['crm'];
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    try {
        // Preparando a consulta SQL para inserir o médico no banco de dados
        $sql = "INSERT INTO medicos (nome, especialidade, crm, usuario, senha) 
                VALUES (:nome, :especialidade, :crm, :usuario, :senha)";
        
        // Prepara a consulta
        $stmt = $conn->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':especialidade', $especialidade);
        $stmt->bindParam(':crm', $crm);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha);

        // Executa a consulta
        $stmt->execute();
        
        echo "Médico cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar médico: " . $e->getMessage();
    }
}
?>

<!-- Formulário HTML para cadastrar médico -->
<form method="POST" action="cadastroM.php">
    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label for="especialidade">Especialidade:</label><br>
    <input type="text" name="especialidade" required><br><br>

    <label for="crm">CRM:</label><br>
    <input type="text" name="crm" required><br><br>

    <label for="usuario">Usuário:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <input type="submit" value="Cadastrar Médico">
</form>
