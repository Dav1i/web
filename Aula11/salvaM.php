<?php
$servidor = 'localhost';
$banco = 'hospital';
$usuario = 'root';
$senha = '';

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $especialidade = $_POST['especialidade'];
        $crm = $_POST['crm'];
        $usuario = $_POST['usuario'];
        $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Hash da senha

        $comandoSQL = "INSERT INTO medicos (nome, especialidade, crm, usuario, senha) VALUES (:nome, :especialidade, :crm, :usuario, :senha)";
        $comando = $conexao->prepare($comandoSQL);

        $comando->bindParam(':nome', $nome);
        $comando->bindParam(':especialidade', $especialidade);
        $comando->bindParam(':crm', $crm);
        $comando->bindParam(':usuario', $usuario);
        $comando->bindParam(':senha', $senha);

        $comando->execute();

        echo "Médico cadastrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
