<?php

include_once "../../dbconfig.php";

$ids = isset($_POST['ids']) ? json_decode($_POST['ids']) : false;

if(!!!$ids):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    foreach($ids as $key => $id):
        $sql       = "DELETE FROM ordens WHERE id='$id'";
        $resultado = mysqli_query($conn, $sql);

        $sql = "DELETE FROM statusxordens WHERE id_ordens='$id'";
        $resultado = mysqli_query($conn, $sql);
    endforeach;

    if(!$resultado) throw new Exception();

    $data['message'] = "Deletado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao deletar registro!";
    echo json_encode($data);
}