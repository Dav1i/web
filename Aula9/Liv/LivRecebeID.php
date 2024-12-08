<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recebe ID do Livro</title>
</head>
<body>
   <?php
    // Verifica se o ID foi passado via GET e se é um valor válido (exemplo: um número inteiro)
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int)$_GET['id']; // Cast para inteiro para garantir que é um número
    ?>
    <form action="LivDados.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="id">ID do Livro que será atualizado: <?php echo $id; ?></label><br>
        <input type="submit" value="Enviar">
    </form>
        
    <?php
    } else {
        echo "<p class='error-message'>ID do Livro não fornecido ou inválido. Por favor, forneça um ID válido.</p>";
    }
    ?>
    <p><a href="livMostrar.php">Voltar</a></p> <!-- Link para voltar -->
</body>
</html>
