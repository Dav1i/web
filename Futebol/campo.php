<?php

// conexão
$servidor = 'localhost';
$banco = 'futebol';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

echo "Conectado!<br>";

echo "Recebido: <br>";
echo $_GET['nome'];
echo "<br>";
echo $_GET['pontos'];

$codigoSQL = "INSERT INTO `partida` (`id`, `nome`, `pontos`) VALUES (NULL, :nm, :pts);";

try {
    $comando = $conexao->prepare($codigoSQL);

    // Usa a quantidade convertida
    $resultado = $comando->execute(array('nm' => $_GET['nome'], 'pts' => $_GET['pontos']));
    
    if($resultado) {
        echo "Comando executado!";
    } else {
        echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro: $e";
}

$conexao = null;

?>
