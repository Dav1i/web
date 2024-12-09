<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$conn = mysqli_connect("localhost", "root", "", "hospital");
if (!$conn) {
    die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['descricao']) && isset($data['id_paciente'])) {
    $descricao = $data['descricao'];
    $id_paciente = $data['id_paciente'];

    $sql = "INSERT INTO receitas (descricao, id_paciente) VALUES ('$descricao', $id_paciente)";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["message" => "Receita salva com sucesso!"]);
    } else {
        echo json_encode(["error" => "Erro ao salvar receita."]);
    }
} else {
    echo json_encode(["error" => "Dados inválidos."]);
}
?>

?>

<!-- Página de retorno para erros ou mensagens de sucesso -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Prescrição</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .error {
            background-color: #f44336;
            color: white;
        }
        .success {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Resultado da Prescrição</h1>

    <!-- Mensagem de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="message error"><?php echo $erro; ?></div>
    <?php elseif ($sucesso): ?>
        <div class="message success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 20px;">
        <a href="painelM.php">Voltar para o painel</a>
    </div>
</div>

</body>
</html>
