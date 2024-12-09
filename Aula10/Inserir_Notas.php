<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $valor = $_POST['valor'];
    $id_aluno = $_POST['id_aluno'];

    // Validação do valor da nota
    if ($valor < 0 || $valor > 100) {
        echo "<p style='color: red; font-weight: bold;'>Erro: A nota deve estar entre 0 e 100!</p>";
        echo "<a href='Cadastro_Notas.php' style='color: #007bff; text-decoration: none;'>Voltar para cadastrar novamente</a>";
        exit;
    }

    try {
        // Verificar se o aluno existe e obter a turma associada
        $stmt = $pdo->prepare("SELECT id_turma FROM alunos WHERE id = :id_aluno");
        $stmt->execute(['id_aluno' => $id_aluno]);
        $id_turma = $stmt->fetchColumn();

        if (!$id_turma) {
            echo "<p style='color: red; font-weight: bold;'>Erro: Aluno não encontrado.</p>";
        } else {
            // Inserir a nota na tabela
            $stmt = $pdo->prepare("INSERT INTO notas (valor, id_aluno, id_turma) VALUES (:valor, :id_aluno, :id_turma)");
            $stmt->execute([
                'valor' => $valor,
                'id_aluno' => $id_aluno,
                'id_turma' => $id_turma
            ]);

            echo "<p style='color: green; font-weight: bold;'>Nota cadastrada com sucesso!</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red; font-weight: bold;'>Erro ao cadastrar nota: " . $e->getMessage() . "</p>";
    }
}
?>
<br>
<a href="Cadastro_Notas.php" style="display: inline-block; margin: 10px 0; color: #007bff; text-decoration: none;'>Voltar para cadastrar mais notas</a><br>
<a href="menu.php" style="display: inline-block; margin: 10px 0; color: #007bff; text-decoration: none;'>Voltar ao menu principal</a>
