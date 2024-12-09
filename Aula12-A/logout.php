<?php
session_start();

// Verifica se o usuário está logado e destrói a sessão adequadamente
if (isset($_SESSION['usuario_id'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login
    header("Location: login.php");
    exit();
} else {
    // Caso o usuário não esteja logado, redireciona para a página de login
    header("Location: login.php");
    exit();
}
?>
