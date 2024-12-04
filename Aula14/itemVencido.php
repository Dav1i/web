<?php
include('config.php');
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para visualizar seus itens vencedores.");
}

$id_usuario = $_SESSION['usuario_id'];
$query = "SELECT * FROM itens WHERE vencedor = $id_usuario";
$result = mysqli_query($conn, $query);

echo "<h1>Itens Vencidos</h1>";
while ($item = mysqli_fetch_assoc($result)) {
    echo "<div>";
    echo "<h3>" . $item['nome'] . "</h3>";
    echo "<p>Valor Mínimo: R$ " . number_format($item['minimo'], 2, ',', '.') . "</p>";
    echo "<p>Estado: " . $item['estado'] . "</p>";
    echo "</div>";
}
?>
