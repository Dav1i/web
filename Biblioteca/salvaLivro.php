<?php

// conexão
$servidor = 'localhost';
$banco = 'biblioteca';
$usuario = 'root';
$senha = '';

$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

echo "Conectado!<br>";

echo "Recebido: <br>";
echo $_GET['titulo'];
echo "<br>";
echo $_GET['idioma'];
echo "<br>";
echo $_GET['qtdPag'];
echo "<br>";
echo $_GET['editora'];
echo "<br>";
echo $_GET['data'];
echo "<br>";
echo $_GET['isbn'];


$codigoSQL = "INSERT INTO `livro`(`id`, `titulo`, `idioma`, `qtdPagina`, `editora`, `dataPublicacao`, `ISBN`) VALUES (NULL, :tt , :idio , :qp, :ed, :publi, :bn);";

try {
    $comando = $conexao->prepare($codigoSQL);

    // Usa a quantidade convertida
    $resultado = $comando->execute(array('tt' => $_GET['titulo'], 'idio' => $_GET['idioma'], 'qp' => $_GET['qtdPag'], 'ed' => $_GET['editora'], 'publi' => $_GET['data'], 'bn' => $_GET['isbn']));
    
    if($resultado) {
        echo "<br>Comando executado!";
    } else {
        echo "Erro ao executar o comando!";
    }
} catch (Exception $e) {
    echo "Erro: $e";
}

$conexao = null;

?>