<?php
$servidor = 'localhost';
$banco = 'produtos';
$usuario = 'root';
$senha = '';

try {
    // Conexão com o banco de dados
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validação e sanitização dos dados recebidos
    $nome = isset($_GET['nome']) ? htmlspecialchars(trim($_GET['nome'])) : '';
    $url = isset($_GET['url']) ? filter_var($_GET['url'], FILTER_SANITIZE_URL) : '';
    $descricao = isset($_GET['descricao']) ? htmlspecialchars(trim($_GET['descricao'])) : '';
    $preco = isset($_GET['preco']) ? floatval($_GET['preco']) : 0.0;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Validação adicional de preço (deve ser positivo)
    if ($preco <= 0) {
        echo "O preço deve ser um valor positivo.";
        exit;
    }

    // Atualização do produto
    $codigoSQL = "UPDATE `produto` SET `nome` = :nome, `url` = :url, `descricao` = :descricao, `preco` = :preco WHERE `id` = :id";
    $comando = $conexao->prepare($codigoSQL);
    
    $resultado = $comando->execute([
        'nome' => $nome,
        'url' => $url,
        'descricao' => $descricao,
        'preco' => $preco,
        'id' => $id
    ]);

    echo $resultado ? "Produto atualizado com sucesso!" : "Erro ao atualizar o produto.";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    $conexao = null; // Fechar a conexão
}
?>
