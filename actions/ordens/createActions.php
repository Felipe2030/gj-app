<?php

include_once "../../dbconfig.php";

session_start();

$id_usuario = $_SESSION['usuario'];
$numero     = isset($_POST['numero']) ? $_POST['numero'] : false;
$status     = isset($_POST['status']) ? $_POST['status'] : false;
$categoria  = isset($_POST['categoria']) ? $_POST['categoria'] : false;

if(!!!$numero || !!!$status || !!!$categoria):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "INSERT INTO ordens (numero, categorias, id_usuario) VALUES ('$numero', '$categoria','$id_usuario')";
    $resultado = mysqli_query($conn, $sql);
    $result_id = mysqli_insert_id($conn);

    $sql = "INSERT INTO statusxordens (id_ordens, status) VALUES ('$result_id', '$status')";
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