<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>

    <form id="cadastroForm">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="tecnico">Técnico</label>
        <input type="checkbox" id="tecnico" name="tecnico"><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <div id="mensagem"></div>

    <script>
        // Função para enviar os dados via AJAX
        document.getElementById('cadastroForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Coleta os dados do formulário
            const nome = document.getElementById('nome').value;
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            const tecnico = document.getElementById('tecnico').checked;  // Verifica se o checkbox foi marcado

            // Criação do objeto para enviar via JSON
            const dados = {
                nome: nome,
                email: email,
                senha: senha,
                tecnico: tecnico
            };

            // Enviar dados via AJAX (Fetch API)
            fetch('recebe.php', {
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
            })
            .catch(error => {
                console.error('Erro ao cadastrar o usuário:', error);
                document.getElementById('mensagem').innerHTML = 'Erro ao cadastrar o usuário.';
            });
        });
    </script>

</body>
</html>
