<?php

include_once "../../dbconfig.php";

$email    = isset($_POST['email']) ? $_POST['email'] : false;
$password = isset($_POST['password']) ? $_POST['password'] : false;

if(!!!$email || !!!$password):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "SELECT * FROM usuarios WHERE email='$email' AND password=md5('$password')";
    $resultado = mysqli_query($conn, $sql);
    
    if(!mysqli_num_rows($resultado)) throw new Exception();
   
    session_start();
    $data = mysqli_fetch_assoc($resultado);
    $_SESSION['usuario'] = $data['id']; 
    
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Usuario ou senha invalido!";
    echo json_encode($data);
}