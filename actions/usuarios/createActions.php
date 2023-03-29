<?php

include_once "../../dbconfig.php";

$email    = isset($_POST['email']) ? $_POST['email'] : false;
$password = isset($_POST['password']) ? md5($_POST['password']) : false;
$abc = $_POST['password'];

if(!!!$email || !!!$password):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "INSERT INTO usuarios (email, password, abc) VALUES ('$email', '$password', '$abc')";
    $resultado = mysqli_query($conn, $sql);

    if(!$resultado) throw new Exception();

    $data['message'] = "Registro criado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao criar registro!";
    echo json_encode($data);
}