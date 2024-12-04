<?php
include('config.php');
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para dar lances.");
}

$id_item = $_GET['id'];
$query = "SELECT * FROM itens WHERE id = $id_item";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor = $_POST['valor'];
    $id_usuario = $_SESSION['usuario_id'];

   
    $query_lance = "INSERT INTO lances (id_item, id_usuario, valor) VALUES ('$id_item', '$id_usuario', '$valor')";
    mysqli_query($conn, $query_lance);
    echo "Lance realizado com sucesso!";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Item</title>
</head>
<body>
    <h1>Detalhes do Item</h1>
    <p>Nome: <?php echo $item['nome']; ?></p>
    <p>Valor Mínimo: R$ <?php echo number_format($item['minimo'], 2, ',', '.'); ?></p>
    <img src="<?php echo $item['imagem']; ?>" alt="Imagem do Item"><br><br>

    <form method="POST">
        <label for="valor">Novo Lance:</label><br>
        <input type="number" name="valor" step="0.01" required><br><br>
        <button type="submit">Enviar Lance</button>
    </form>
</body>
</html>
