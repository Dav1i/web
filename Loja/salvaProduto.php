<?php

// conexão
$servidor = 'localhost';
$banco = 'loja';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

echo "Conectado!<br>";

echo "Recebido: <br>";
echo $_GET['nome'];
echo "<br>";
echo $_GET['url'];
echo "<br>";
echo $_GET['desc'];
echo "<br>";
echo $_GET['preco'];

// Converte a vírgula em ponto na quantidade
$preco = str_replace(",", ".", $_GET['preco']);

$codigoSQL = "INSERT INTO `produto` (`id`, `nome`, `url`, `descricao`, `preco`) VALUES (NULL, :nm, :url, :desc, :preco)";

try {
    $comando = $conexao->prepare($codigoSQL);

    // Usa a quantidade convertida
    $resultado = $comando->execute(array('nm' => $_GET['nome'], 'url' => $_GET['url'], 'desc' => $_GET['desc'], 'preco' => $preco));
    
    if($resultado) {
        echo "<br>Comando executado!";
    } else {
        echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

$conexao = null;

?>


