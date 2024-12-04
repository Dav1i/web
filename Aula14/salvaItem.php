<?php
session_start();
include('config.php');

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para cadastrar um item.");
}

$nome = $_POST['nome'];
$minimo = $_POST['minimo'];
$imagem = $_FILES['imagem']['name'];


$diretorio = 'uploads/'; 
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0777, true); 
}


$imagem_path = $diretorio . basename($imagem);


if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_path)) {
    echo "Arquivo enviado com sucesso!<br>";
} else {
    echo "Erro ao enviar o arquivo.";
}


$query = "INSERT INTO itens (nome, imagem, minimo, estado) VALUES ('$nome', '$imagem_path', '$minimo', 'aberto')";
if (mysqli_query($conn, $query)) {
    echo "Item cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar item: " . mysqli_error($conn);
}
?>
