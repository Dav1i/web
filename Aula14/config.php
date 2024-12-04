<?php
$host = 'localhost';  
$dbname = 'leilao';   
$username = 'root';   
$password = '';       


$conn = mysqli_connect($host, $username, $password, $dbname);


if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}


mysqli_set_charset($conn, 'utf8');


register_shutdown_function(function() {
    global $conn;
    mysqli_close($conn);
});
?>
