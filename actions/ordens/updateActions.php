<?php

include_once "../../dbconfig.php";

session_start();

$id         = isset($_POST['id']) ? $_POST['id'] : false;
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
    $sql = "INSERT INTO statusxordens (id_ordens, status) VALUES ('$id', '$status')";
    $resultado = mysqli_query($conn, $sql);

    $sql = "UPDATE ordens SET numero='$numero', categorias='$categoria', id_usuario='$id_usuario' WHERE id='$id'";
    $resultado = mysqli_query($conn, $sql);

    if(!$resultado) throw new Exception();

    $data['message'] = "Editado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao editar registro!";
    echo json_encode($data);
}