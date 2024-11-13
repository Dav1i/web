<?php
session_start();
if (!isset($_SESSION['enfermeiro_id'])) {
    header("Location: login.php");
    exit();
}

include('hospital.php');

// Verificar se a receita existe
$receitas_id = $_GET['receitas_id'];
$sql = "SELECT r.*, p.nome AS paciente_nome FROM receitas r
        JOIN pacientes p ON r.paciente_id = p.id
        WHERE r.id = '$receita_id'";
$result = mysqli_query($conn, $sql);
$receita = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_hora_registro = date("Y-m-d H:i:s");

    $sql_administracao = "INSERT INTO administracoes (receita_id, data_hora_registro) 
                          VALUES ('$receita_id', '$data_hora_registro')";

    if (mysqli_query($conn, $sql_administracao)) {
        echo "Administração registrada com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conn);
    }
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
