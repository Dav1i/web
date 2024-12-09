<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);

    // Validação do nome da turma
    if (empty($nome)) {
        echo "<p style='color: red; font-weight: bold;'>Nome da turma é obrigatório!</p>";
        echo "<a href='Cadastro_Turma.php'>Voltar para o cadastro</a>";
        exit;
    }

    try {
        // Inserção da nova turma no banco de dados
        $stmt = $pdo->prepare("INSERT INTO turmas (nome) VALUES (:nome)");
        $stmt->execute(['nome' => $nome]);

        echo "<p style='color: green; font-weight: bold;'>Turma cadastrada com sucesso!</p>";
    } catch (Exception $e) {
        echo "<p style='color: red; font-weight: bold;'>Erro ao cadastrar turma: " . $e->getMessage() . "</p>";
    }
}
?>
<br>
<a href="Cadastro_Turma.php" style="display: inline-block; margin: 10px 0; color: #007bff; text-decoration: none;">Voltar para cadastrar mais turmas</a><br>
<a href="menu.php" style="display: inline-block; margin: 10px 0; color: #007bff; text-decoration: none;">Voltar ao menu principal</a>
