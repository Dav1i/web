<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Configuração da conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "", "hospital");
if (!$conn) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
}

// Lendo os dados recebidos
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nome']) && isset($data['especialidade'])) {
    $nome = $data['nome'];
    $especialidade = $data['especialidade'];

    $sql = "INSERT INTO medicos (nome, especialidade) VALUES ('$nome', '$especialidade')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["message" => "Médico cadastrado com sucesso!"]);
    } else {
        echo json_encode(["error" => "Erro ao cadastrar médico."]);
    }
} else {
    echo json_encode(["error" => "Dados inválidos."]);
}
?>



<!-- Formulário HTML para cadastrar médico -->
<form method="POST" action="cadastroM.php">
    <label for="nome">Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label for="especialidade">Especialidade:</label><br>
    <input type="text" name="especialidade" required><br><br>

    <label for="crm">CRM:</label><br>
    <input type="text" name="crm" required><br><br>

    <label for="usuario">Usuário:</label><br>
    <input type="text" name="usuario" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <input type="submit" value="Cadastrar Médico">
</form>
