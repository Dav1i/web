<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Chamado</title>
</head>
<body>
    <h2>Abrir Novo Chamado</h2>

    <form id="cadastroChamadoForm">
        <label for="departamento">Departamento:</label><br>
        <input type="text" id="departamento" name="departamento" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" required></textarea><br><br>

        <label for="prioridade">Prioridade:</label><br>
        <select id="prioridade" name="prioridade" required>
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Alta">Alta</option>
        </select><br><br>

        <label for="responsavel">Responsável:</label><br>
        <input type="text" id="responsavel" name="responsavel" required><br><br>

        <label for="data_hora_limite">Data e Hora Limite:</label><br>
        <input type="datetime-local" id="data_hora_limite" name="data_hora_limite" required><br><br>

        <button type="submit">Criar Chamado</button>
    </form>

    <div id="mensagem"></div>

    <script>
        // Função para enviar os dados via AJAX
        document.getElementById('cadastroChamadoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const departamento = document.getElementById('departamento').value;
            const descricao = document.getElementById('descricao').value;
            const prioridade = document.getElementById('prioridade').value;
            const responsavel = document.getElementById('responsavel').value;
            const data_hora_limite = document.getElementById('data_hora_limite').value;

            const dados = {
                departamento: departamento,
                descricao: descricao,
                prioridade: prioridade,
                responsavel: responsavel,
                data_hora_limite: data_hora_limite
            };

            fetch('recebeC.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('mensagem').innerHTML = data.mensagem;
            })
            .catch(error => {
                console.error('Erro ao criar chamado:', error);
                document.getElementById('mensagem').innerHTML = 'Erro ao criar o chamado.';
            });
        });
    </script>

</body>
</html>
