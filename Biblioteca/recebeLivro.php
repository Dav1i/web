<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Recebe dados</title>
</head>
<body>
    <form action="salvaLivro.php">
       <label for="titulo">Titulo:</label>
       <input type="text" name="titulo"><br>
       <label for="idioma">idioma:</label>
       <input type="text" name="idioma"><br>
       <label for="qtdPag">Quantidade de Pagina:</label> 
       <input type="text" name="qtdPag"><br>
       <label for="editora">Editora:</label> 
       <input type="text" name="editora"><br>
       <label for="data">Data de Publicação:</label> 
       <input type="date" name="data"><br>
       <label for="isbn">ISBN:</label> 
       <input type="text" name="isbn"><br>
       <input type="submit">
    </form>
</body>
</html>