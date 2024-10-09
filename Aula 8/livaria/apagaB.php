<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apaga item</title>
</head>
<body>
   <?php
    $id = $_GET['id'];
    $comandoSQL = "DELETE FROM livro WHERE `livro`.`id` = $id";
    
    $servidor = 'localhost';
    $banco = 'biblioteca';
    $usuario = 'root';
    $senha = '';
    
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    
    try{
        $resultado = $conexao->exec($comandoSQL);
        
        if($resultado != 0){
            echo "Item apagado";
        } else {
            echo "Erro ao apagar o item!";
        }
    } catch(Exception $e){
        echo "Erro $e";
    }
    
    ?>
</body>
</html>