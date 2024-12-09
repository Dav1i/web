<?php 
include 'conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Listar Notas</title>
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
        p {
            text-align: center;
            font-size: 1rem;
        }
        a {
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
        a:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Notas do Aluno</h2>
        <?php
        // Obtenção do ID do aluno via GET
        $id_aluno = $_GET['id_aluno'] ?? null;

        if ($id_aluno) {
            // Consulta para buscar notas relacionadas ao aluno
            $stmt = $pdo->prepare("SELECT valor, id_turma FROM notas WHERE id_aluno = :id_aluno");
            $stmt->execute(['id_aluno' => $id_aluno]);
            $notas = $stmt->fetchAll();

            // Verifica se há resultados e exibe a tabela
            if (!empty($notas)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Nota</th>
                                <th>Turma</th>
                            </tr>
                        </thead>
                        <tbody>";
                foreach ($notas as $nota) {
                    echo "<tr>
                            <td>{$nota['valor']}</td>
                            <td>{$nota['id_turma']}</td>
                          </tr>";
                }
                echo "  </tbody>
                      </table>";
            } else {
                echo "<p>Nenhuma nota encontrada para este aluno.</p>";
            }
        } else {
            echo "<p>ID do aluno não fornecido.</p>";
        }
        ?>
        <a href="Listar_Alunos.php">Voltar</a>
    </div>
</body>
</html>
