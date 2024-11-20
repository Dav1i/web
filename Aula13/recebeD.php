<?php
// Configuração do banco de dados
$host = 'localhost';  // ou o IP do seu servidor MySQL
$dbname = 'sch';
$username = 'root';   // seu nome de usuário do MySQL
$password = '';       // sua senha do MySQL

// Cabeçalhos para resposta JSON
header('Content-Type: application/json');

// Receber os dados em JSON
$dados = json_decode(file_get_contents('php://input'), true);

// Verificar se o dado 'nome' foi recebido corretamente
if (isset($dados['nome'])) {
    $nome = $dados['nome'];

    try {
        // Conectar ao banco de dados com PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a consulta SQL para inserir o nome do departamento
        $sql = "INSERT INTO departamentos (nome) VALUES (:nome)";
        $stmt = $pdo->prepare($sql);

        // Vincular o parâmetro
        $stmt->bindParam(':nome', $nome);

        // Executar a consulta
        if ($stmt->execute()) {
            // Se a inserção for bem-sucedida, retornar uma resposta JSON
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Departamento cadastrado com sucesso!'
            ]);
        } else {
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Erro ao cadastrar o departamento.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()
        ]);
    }
} else {
    // Se o nome do departamento não for fornecido
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Nome do departamento não fornecido.'
    ]);
}
?>
