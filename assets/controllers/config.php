<?php 

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "base_dados";
$port = 3308;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=".$dbname, $user, $pass);

    //echo "Conexao realizada com sucesso";

} catch (PDOException $err) {

    //echo "Não Houve conexão" . $err->getMessage();

}
