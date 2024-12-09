<?php 
include 'conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Listar Alunos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td a {
            color: #0056b3;
            text-decoration: none;
            transition: color 0.3s;
        }
        td a:hover {
            color: #003f8a;
        }
        p {
            text-align: center;
            font-size: 1rem;
        }
        a.back {
            display: inline-block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #0056b3;
            padding: 10px 20px;
            border: 1px solid #0056b3;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        a.back:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Alunos da Turma</h2>
        <?php
        // Obtenção do ID da turma via GET
        $id_turma = $_GET['id_turma'] ?? null;

        if ($id_turma) {
            // Consulta para buscar alunos relacionados à turma
            $stmt = $pdo->prepare("SELECT id, nome FROM alunos WHERE id_turma = :id_turma");
            $stmt->execute(['id_turma' => $id_turma]);
            $alunos = $stmt->fetchAll();

            // Verifica se há resultados e exibe a tabela
            if (!empty($alunos)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($alunos as $aluno) {
                    echo "<tr>
                            <td>{$aluno['id']}</td>
                            <td>{$aluno['nome']}</td>
                            <td><a href='Listar_Notas_result.php?id_aluno={$aluno['id']}'>Ver Notas</a></td>
                          </tr>";
                }
                echo "</tbody>
                      </table>";
            } else {
                echo "<p>Nenhum aluno encontrado para esta turma.</p>";
            }
        } else {
            echo "<p>ID da turma não fornecido.</p>";
        }
        ?>
        <a href="Listar_Alunos.php" class="back">Voltar</a>
    </div>
</body>
</html>
