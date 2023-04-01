<?php

include_once "../../dbconfig.php";

session_start();
date_default_timezone_set('America/Sao_Paulo');

$id         = isset($_POST['id']) ? $_POST['id'] : false;
$id_usuario = $_SESSION['usuario'];
$numero     = isset($_POST['numero']) ? $_POST['numero'] : false;
$status     = isset($_POST['status']) ? $_POST['status'] : false;
$id_categorias  = isset($_POST['categoria']) ? $_POST['categoria'] : false;
$id_fornecedor  = isset($_POST['fornecedor']) ? $_POST['fornecedor'] : false;

if(!!!$numero || !!!$status || !!!$id_categorias || !!!$id_fornecedor):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

$timestamp = time();
$data_formatada = date('Y-m-d H:i:s', $timestamp);

try {
    $sql = "INSERT INTO statusxordens (id_ordens, status, data) VALUES ('$id', '$status', '$data_formatada')";
    $resultado_ordens = mysqli_query($conn, $sql);

    if(!$resultado_ordens) throw new Exception();

    $sql = "UPDATE ordens SET numero='$numero', id_categorias='$id_categorias', id_usuario='$id_usuario', id_fornecedor='$id_fornecedor' WHERE id='$id'";
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