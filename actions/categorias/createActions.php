<?php

include_once "../../dbconfig.php";

session_start();

$id_usuario = $_SESSION['usuario'];
$nome  = isset($_POST['nome']) ? $_POST['nome'] : false;

if(!!!$nome):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "INSERT INTO categorias (nome, id_usuario) VALUES ('$nome', '$id_usuario')";
    $resultado = mysqli_query($conn, $sql);
    $result_id = mysqli_insert_id($conn);

    if(!$resultado) throw new Exception();

    $sql = "SELECT * FROM categorias WHERE id = '$result_id'";
    $resultado = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($resultado);

    $data['message'] = "Registro criado com sucesso!";
    $data['status'] = true;
    $data['value'] = $row;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao criar registro!";
    echo json_encode($data);
}