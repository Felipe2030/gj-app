<?php

include_once "../../dbconfig.php";

$id       = isset($_POST['id']) ? $_POST['id'] : false;
$email    = isset($_POST['email']) ? $_POST['email'] : false;
$password = isset($_POST['password']) ? md5($_POST['password']) : false;

if(!!!$email || !!!$password):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "UPDATE usuarios SET email='$email', password='$password' WHERE id='$id'";
    $resultado = mysqli_query($conn, $sql);

    if(!$resultado) throw new Exception();

    $data['message'] = "Editado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao criar registro!";
    echo json_encode($data);
}