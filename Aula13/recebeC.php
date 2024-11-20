<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'sch';
$username = 'root';
$password = '';

header('Content-Type: application/json');

// Receber os dados do chamado em JSON
$dados = json_decode(file_get_contents('php://input'), true);

// Verificar se os dados foram recebidos corretamente
if (isset($dados['departamento'], $dados['descricao'], $dados['prioridade'], $dados['responsavel'], $dados['data_hora_limite'])) {
    $departamento = $dados['departamento'];
    $descricao = $dados['descricao'];
    $prioridade = $dados['prioridade'];
    $responsavel = $dados['responsavel'];  // Aqui você deve implementar a lógica para pegar o ID do responsável
    $data_hora_limite = $dados['data_hora_limite'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consultar o ID do departamento
        $stmt = $pdo->prepare("SELECT id FROM departamentos WHERE nome = :departamento");
        $stmt->bindParam(':departamento', $departamento);
        $stmt->execute();
        $departamento_id = $stmt->fetchColumn();

        // Consultar o ID do responsável
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nome = :responsavel");
        $stmt->bindParam(':responsavel', $responsavel);
        $stmt->execute();
        $responsavel_id = $stmt->fetchColumn();

        // Inserir o chamado
        $stmt = $pdo->prepare("INSERT INTO chamados (criador_id, departamento_id, descricao, prioridade, responsavel_id, data_hora_limite) 
            VALUES (:criador_id, :departamento_id, :descricao, :prioridade, :responsavel_id, :data_hora_limite)");

        // Você pode pegar o ID do criador diretamente da sessão do usuário
        // Exemplo: $criador_id = $_SESSION['user_id']; 
        $criador_id = 1;  // Isso é apenas um exemplo

        $stmt->bindParam(':criador_id', $criador_id);
        $stmt->bindParam(':departamento_id', $departamento_id);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':responsavel_id', $responsavel_id);
        $stmt->bindParam(':data_hora_limite', $data_hora_limite);

        if ($stmt->execute()) {
            echo json_encode(['mensagem' => 'Chamado criado com sucesso!']);
        } else {
            echo json_encode(['mensagem' => 'Erro ao criar chamado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['mensagem' => 'Dados incompletos.']);
}
?>
