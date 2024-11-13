<?php
// Inclui o arquivo de conexão com o banco
include('hospital.php');

// Definindo o cabeçalho para retornar um JSON
header('Content-Type: application/json');

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados da requisição JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Valida os dados recebidos
    if (isset($data['nome'], $data['especialidade'], $data['crm'], $data['usuario'], $data['senha'])) {
        $nome = $data['nome'];
        $especialidade = $data['especialidade'];
        $crm = $data['crm'];
        $usuario = $data['usuario'];
        $senha = password_hash($data['senha'], PASSWORD_DEFAULT); // Criptografando a senha

        try {
            // Preparando a consulta SQL para inserir o médico no banco de dados
            $sql = "INSERT INTO medicos (nome, especialidade, crm, usuario, senha) 
                    VALUES (:nome, :especialidade, :crm, :usuario, :senha)";
            
            // Prepara a consulta
            $stmt = $conn->prepare($sql);

            // Bind dos parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':especialidade', $especialidade);
            $stmt->bindParam(':crm', $crm);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':senha', $senha);

            // Executa a consulta
            $stmt->execute();

            // Retorna a resposta de sucesso
            echo json_encode(['message' => 'Médico cadastrado com sucesso!']);
        } catch (PDOException $e) {
            // Caso haja erro na execução do SQL
            echo json_encode(['error' => 'Erro ao cadastrar médico: ' . $e->getMessage()]);
        }
    } else {
        // Se algum dado obrigatórios não foi enviado
        echo json_encode(['error' => 'Dados incompletos.']);
    }
} else {
    // Caso não seja um POST
    echo json_encode(['error' => 'Método HTTP inválido. Utilize POST.']);
}
?>
