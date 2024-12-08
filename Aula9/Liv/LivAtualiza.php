<?php
// Configurações do banco de dados
$config = [
    'host' => 'localhost',
    'dbname' => 'livros',
    'user' => 'root',
    'password' => ''
];

try {
    // Estabelecendo conexão com o banco de dados
    $conexao = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}",
        $config['user'],
        $config['password']
    );
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validação e sanitização dos dados recebidos via GET
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $titulo = filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING);
    $idioma = filter_input(INPUT_GET, 'idioma', FILTER_SANITIZE_STRING);
    $qtdPaginas = filter_input(INPUT_GET, 'qtdPaginas', FILTER_VALIDATE_INT);
    $editora = filter_input(INPUT_GET, 'editora', FILTER_SANITIZE_STRING);
    $dataPublicacao = filter_input(INPUT_GET, 'dataPublicacao', FILTER_SANITIZE_STRING);
    $ISBN = filter_input(INPUT_GET, 'ISBN', FILTER_SANITIZE_STRING);

    if ($id && $titulo && $idioma && $qtdPaginas && $editora && $dataPublicacao && $ISBN) {
        // Comando SQL para atualizar o livro
        $codigoSQL = "UPDATE `livro` 
                      SET `titulo` = :titulo, 
                          `idioma` = :idioma, 
                          `qtdPaginas` = :qtdPaginas, 
                          `editora` = :editora, 
                          `dataPublicacao` = :dataPublicacao, 
                          `ISBN` = :ISBN 
                      WHERE `id` = :id";

        $comando = $conexao->prepare($codigoSQL);

        // Executa a consulta
        $resultado = $comando->execute([
            ':titulo' => $titulo,
            ':idioma' => $idioma,
            ':qtdPaginas' => $qtdPaginas,
            ':editora' => $editora,
            ':dataPublicacao' => $dataPublicacao,
            ':ISBN' => $ISBN,
            ':id' => $id
        ]);

        echo $resultado ? "<p>Livro atualizado com sucesso!</p>" : "<p>Erro ao atualizar o livro.</p>";
    } else {
        echo "<p>Dados inválidos ou incompletos fornecidos.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
} finally {
    $conexao = null; // Fecha a conexão
}
?>

