<?php
include('config.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    
    $nova_senha = hash('sha256', $senha);

    
    $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$nova_senha')";
    if (mysqli_query($conn, $query)) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário: " . mysqli_error($conn);
    }
}
?>
