<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Departamento</title>
</head>
<body>
    <h2>Cadastro de Departamento</h2>

    <form id="cadastroDepartamentoForm">
        <label for="nome">Nome do Departamento:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <button type="submit">Cadastrar Departamento</button>
    </form>

    <div id="mensagem"></div>

    <script>
        // Função para enviar os dados via AJAX
        document.getElementById('cadastroDepartamentoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Coleta o nome do departamento
            const nome = document.getElementById('nome').value;

            // Criação do objeto para enviar via JSON
            const dados = { nome: nome };

            // Enviar dados via AJAX (Fetch API)
            fetch('recebeD.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                // Exibe a resposta do servidor
                document.getElementById('mensagem').innerHTML = data.mensagem;
                if (data.sucesso) {
                    document.getElementById('nome').value = ''; // Limpa o campo após sucesso
                }
            })
            .catch(error => {
                console.error('Erro ao cadastrar o departamento:', error);
                document.getElementById('mensagem').innerHTML = 'Erro ao cadastrar o departamento.';
            });
        });
    </script>

</body>
</html>
