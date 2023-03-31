<?php

include_once "../../dbconfig.php";

session_start();

$id_usuario = $_SESSION['usuario'];
$numero     = isset($_POST['numero']) ? $_POST['numero'] : false;
$status     = isset($_POST['status']) ? $_POST['status'] : false;
$id_categoria  = isset($_POST['categoria']) ? $_POST['categoria'] : false;
$id_fornecedor = isset($_POST['fornecedor']) ? $_POST['fornecedor'] : false;

if(!!!$numero || !!!$status || !!!$id_categoria || !!!$id_fornecedor):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

try {
    $sql = "INSERT INTO ordens (numero, id_categorias, id_usuario, id_fornecedor) VALUES ('$numero', '$id_categoria','$id_usuario','$id_fornecedor')";
    $resultado_ordens = mysqli_query($conn, $sql);
    $result_id = mysqli_insert_id($conn);

    if(!$resultado_ordens) throw new Exception();

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