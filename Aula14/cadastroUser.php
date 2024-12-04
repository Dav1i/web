<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <script>
        function cadastrarUsuario() {
            const nome = document.getElementById("nome").value;
            const email = document.getElementById("email").value;
            const senha = document.getElementById("senha").value;

            const dados = new FormData();
            dados.append('nome', nome);
            dados.append('email', email);
            dados.append('senha', senha);

            fetch('salvaUser.php', {
                method: 'POST',
                body: dados
            })
            .then(response => response.text())
            .then(data => alert(data));
        }
    </script>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form onsubmit="event.preventDefault(); cadastrarUsuario();">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
