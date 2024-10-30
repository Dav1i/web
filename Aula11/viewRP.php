<?php
session_start();
$servidor = 'localhost';
$banco = 'hospital';
$usuario = 'root';
$senha = '';

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $comandoSQL = "SELECT r.*, p.nome AS nome_paciente FROM receitas r JOIN pacientes p ON r.paciente_id = p.id WHERE r.data_administracao >= CURDATE() AND r.registrada IS NULL";
    $comando = $conexao->prepare($comandoSQL);
    $comando->execute();

    $receitas = $comando->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!
