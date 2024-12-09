<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $id_turma = $_POST['id_turma'];

    // Verificar se o nome do aluno já está cadastrado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM alunos WHERE nome = :nome");
    $stmt->execute(['nome' => $nome]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<p style='color: red; font-weight: bold;'>Erro: Este aluno já está cadastrado em outra turma!</p>";
        echo "<a href='Cadastro_Alunos.php' style='color: #007bff; text-decoration: none;'>Voltar para o cadastro de alunos</a>";
    } else {
        try {
            // Inserir o aluno na turma
            $stmt = $pdo->prepare("INSERT INTO alunos (nome, id_turma) VALUES (:nome, :id_turma)");
            $stmt->execute(['nome' => $nome, 'id_turma' => $id_turma]);

            echo "<p style='color: green; font-weight: bold;'>Aluno cadastrado com sucesso!</p>";
        } catch (Exception $e) {
            echo "<p style='color: red; font-weight: bold;'>Erro ao cadastrar o aluno: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<br>
<a href="Cadastro_Alunos.php" style="display: inline-block; margin: 10px 0; color: #007bff; text-decoration: none;">Voltar para cadastrar mais alunos</a><br>
<a href="menu.php" style="display: inline-block; margin: 10px 0; color: #007bff; text-decoration: none;">Voltar ao menu principal</a>
