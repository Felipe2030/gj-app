<?php

// Configurações do banco de dados
$servername = "us-cdbr-east-06.cleardb.net";
$username   = "b1c89cb2e54527";
$password   = "5bebb40a";
$dbname     = "heroku_1e575b60205ec5a";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
