<?php

include_once "../../dbconfig.php";

session_start();

$id_usuario = $_SESSION['usuario'];
$nome  = isset($_POST['nome']) ? $_POST['nome'] : false;
$ganho = isset($_POST['ganho']) ? $_POST['ganho'] : false;


if(!!!$nome || !!!$ganho):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "INSERT INTO fornecedor (nome, ganho_entrega, id_usuario) VALUES ('$nome', '$ganho', '$id_usuario')";
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