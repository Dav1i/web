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
        $nome_paciente = $_POST['nome_paciente'];
        $nome_medicamento = $_POST['nome_medicamento'];
        $data_administracao = $_POST['data_administracao'];
        $hora_administracao = $_POST['hora_administracao'];
        $dose = $_POST['dose'];

        // Verificar se o paciente já está cadastrado
        $sql = "SELECT id FROM pacientes WHERE nome = :nome";
        $comando = $conexao->prepare($sql);
        $comando->bindParam(':nome', $nome_paciente);
        $comando->execute();

        if ($comando->rowCount() > 0) {
            $paciente = $comando->fetch(PDO::FETCH_ASSOC);
            $paciente_id = $paciente['id'];

            // Inserir a prescrição
            $comandoSQL = "INSERT INTO receitas (paciente_id, nome_medicamento, data_administracao, hora_administracao, dose) VALUES (:paciente_id, :nome_medicamento, :data_administracao, :hora_administracao, :dose)";
            $comando = $conexao->prepare($comandoSQL);

            $comando->bindParam(':paciente_id', $paciente_id);
            $comando->bindParam(':nome_medicamento', $nome_medicamento);
            $comando->bindParam(':data_administracao', $data_administracao);
            $comando->bindParam(':hora_administracao', $hora_administracao);
            $comando->bindParam(':dose', $dose);

            $comando->execute();

            echo "Prescrição cadastrada com sucesso!";
        } else {
            echo "Paciente não encontrado. Por favor, cadastre-o primeiro.";
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
