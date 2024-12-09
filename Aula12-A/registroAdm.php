<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$conn = mysqli_connect("localhost", "root", "", "hospital");
if (!$conn) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id_receita'])) {
    $id_receita = $data['id_receita'];

    $sql = "UPDATE receitas SET status = 'administrada' WHERE id = $id_receita";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["message" => "Receita administrada com sucesso!"]);
    } else {
        echo json_encode(["error" => "Erro ao administrar receita."]);
    }
} else {
    echo json_encode(["error" => "Dados inválidos."]);
}
?>

<h2>Registrar Administração</h2>
<p>Paciente: <?= $receita['paciente_nome'] ?></p>
<p>Medicamento: <?= $receita['nome_medicamento'] ?></p>
<p>Data de Administração: <?= $receita['data_administracao'] ?></p>
<p>Hora de Administração: <?= $receita['hora_administracao'] ?></p>

<form method="POST" action="registrar_administracao.php?receita_id=<?= $receita_id ?>">
    <input type="submit" value="Registrar Administração">
</form>
