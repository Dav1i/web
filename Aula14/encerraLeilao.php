<?php
session_start();
include('config.php');


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erro: O ID do item não foi fornecido.");
}

$id_item = $_GET['id'];


$query = "SELECT * FROM itens WHERE id = $id_item";
$result = mysqli_query($conn, $query);


if (mysqli_num_rows($result) == 0) {
    die("Erro: O item com o ID $id_item não foi encontrado.");
}

$item = mysqli_fetch_assoc($result);


if ($_SESSION['usuario_id'] != $item['id_usuario']) {
    die("Você não tem permissão para encerrar este leilão.");
}


$query_lance_max = "SELECT id_usuario, MAX(valor) AS maior_lance FROM lances WHERE id_item = $id_item";
$result_lance = mysqli_query($conn, $query_lance_max);
$lance = mysqli_fetch_assoc($result_lance);


if (!$lance) {
    die("Erro: Nenhum lance foi feito para este item.");
}

$id_vencedor = $lance['id_usuario'];


$query_update = "UPDATE itens SET estado = 'encerrado', vencedor = $id_vencedor WHERE id = $id_item";
if (mysqli_query($conn, $query_update)) {
    echo "Leilão encerrado com sucesso! Vencedor: ID $id_vencedor.";
} else {
    echo "Erro ao encerrar o leilão: " . mysqli_error($conn);
}
?>
