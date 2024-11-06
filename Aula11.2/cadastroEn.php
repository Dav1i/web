<?php
session_start();
include('hospital.php'); // Conectar ao banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $coren = $_POST['coren'];
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    // Verifica se o usuário já existe
    $sql_check = "SELECT * FROM enfermeiros WHERE usuario = :usuario";
    $stmt = $conn->prepare($sql_check);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Usuário já existe!";
    } else {
        // Inserir o enfermeiro no banco de dados
        $sql_insert = "INSERT INTO enfermeiros (nome, coren, usuario, senha) VALUES (:nome, :coren, :usuario, :senha)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':coren', $coren);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha);

        if ($stmt->execute()) {
            echo "Enfermeiro cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o enfermeiro.";
        }
    }
}
?>

<form method="POST" action="cadastroEn.php">
    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label for="coren">COREN:</label><br>
    <input type="text" name="coren" required><br><br>

    <label for="usuario">Usuário:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <input type="submit" value="Cadastrar Enfermeiro">
</form>
