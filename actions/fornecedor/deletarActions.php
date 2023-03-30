<?php

include_once "../../dbconfig.php";

$id = isset($_POST['id']) ? $_POST['id'] : false;

if(!!!$id):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql       = "DELETE FROM fornecedor WHERE id='$id'";
    $resultado = mysqli_query($conn, $sql);

    if(!$resultado) throw new Exception();

    $data['message'] = "Deletado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao deletar registro!";
    echo json_encode($data);
}