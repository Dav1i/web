<?php
session_start();
$servidor = 'localhost';
$banco = 'hospital';
$usuario = 'root';
$senha = '';

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $comandoSQL = "SELECT * FROM medicos WHERE usuario = :usuario";
        $comando = $conexao->prepare($comandoSQL);
        $comando->bindParam(':usuario', $usuario);
        $comando->execute();

        if ($comando->rowCount() > 0) {
            $medico = $comando->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $medico['senha'])) {
                $_SESSION['usuario'] = $medico['usuario'];
                $_SESSION['tipo'] = 'medico';
                header("Location: dashboard_medico.php"); // Redirecionar para a dashboard
                exit();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
