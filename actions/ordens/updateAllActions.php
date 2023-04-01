<?php

include_once "../../dbconfig.php";

date_default_timezone_set('America/Sao_Paulo');

$status = isset($_POST['status']) ? $_POST['status'] : false;
$ids    = isset($_POST['ids']) ? json_decode($_POST['ids']) : false;

if(!!!$status || !!!$ids):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

$timestamp = time();
$data_formatada = date('Y-m-d H:i:s', $timestamp);

try {
    foreach($ids as $key => $id):
        $sql = "INSERT INTO statusxordens (id_ordens, status, data) VALUES ('$id', '$status', '$data_formatada')";
        $resultado = mysqli_query($conn, $sql);
    endforeach;

    if(!$resultado) throw new Exception();

    $data['message'] = "Editado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao editar registro!";
    echo json_encode($data);
}