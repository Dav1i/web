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

// Verificar se os dados necessários foram recebidos
if (isset($dados['nome'], $dados['email'], $dados['senha'])) {
    $nome = $dados['nome'];
    $email = $dados['email'];
    $senha = password_hash($dados['senha'], PASSWORD_BCRYPT);  // Criptografando a senha
    $tecnico = $dados['tecnico'] ? 1 : 0;  // Converte o valor do checkbox para 1 (true) ou 0 (false)

    try {
        // Conectar ao banco de dados com PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a consulta SQL para inserir os dados
        $sql = "INSERT INTO usuarios (nome, email, senha, tecnico) VALUES (:nome, :email, :senha, :tecnico)";
        $stmt = $pdo->prepare($sql);

        // Vincular os parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tecnico', $tecnico);

        // Executar a consulta
        if ($stmt->execute()) {
            echo json_encode(['mensagem' => 'Usuário cadastrado com sucesso!']);
        } else {
            echo json_encode(['mensagem' => 'Erro ao cadastrar o usuário.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['mensagem' => 'Dados incompletos.']);
}
?>
