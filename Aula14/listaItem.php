<?php
include('config.php');
$query = "SELECT * FROM itens WHERE estado = 'aberto'";
$result = mysqli_query($conn, $query);

echo "<h1>Itens em Leilão</h1>";
while ($item = mysqli_fetch_assoc($result)) {
    echo "<div>";
    echo "<h3>" . $item['nome'] . "</h3>";
    echo "<p>Valor Mínimo: R$ " . number_format($item['minimo'], 2, ',', '.') . "</p>";
    echo "<a href='detalheItem.php?id=" . $item['id'] . "'>Ver Detalhes</a>";
    echo "</div>";
}
?>
