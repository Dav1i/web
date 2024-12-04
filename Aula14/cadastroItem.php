<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para cadastrar um item.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item para Leilão</title>
</head>
<body>
    <h1>Cadastrar Item para Leilão</h1>
    <form action="salvaItem.php" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome do Item:</label><br>
        <input type="text" name="nome" required><br><br>

        <label for="imagem">Imagem do Item:</label><br>
        <input type="file" name="imagem" accept="image/*" required><br><br>

        <label for="minimo">Lance Mínimo:</label><br>
        <input type="number" step="0.01" name="minimo" required><br><br>

        <button type="submit">Cadastrar Item</button>
    </form>
</body>
</html>
