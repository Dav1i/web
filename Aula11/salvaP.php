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
        $leito = $_POST['leito'];

        $comandoSQL = "INSERT INTO pacientes (nome, leito) VALUES (:nome, :leito)";
        $comando = $conexao->prepare($comandoSQL);

        $comando->bindParam(':nome', $nome);
        $comando->bindParam(':leito', $leito);

        $comando->execute();

        echo "Paciente cadastrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
