<?php

include_once "../../dbconfig.php";

session_start();
date_default_timezone_set('America/Sao_Paulo');

$id_usuario = $_SESSION['usuario'];
$numeros     = isset($_POST['numero']) ? $_POST['numero'] : false;
$status     = isset($_POST['status']) ? $_POST['status'] : false;
$id_categoria  = isset($_POST['categoria']) ? $_POST['categoria'] : false;
$id_fornecedor = isset($_POST['fornecedor']) ? $_POST['fornecedor'] : false;


if(!!!$numeros || !!!$status || !!!$id_categoria || !!!$id_fornecedor):
    $data['status']  = false;
    $data['message'] = "Preencha todos os campos!";
    echo json_encode($data);
    exit;
endif;

$numeros = array_filter($numeros, function($valor) {
    return !empty($valor);
});

$timestamp = time();
$data_formatada = date('Y-m-d H:i:s', $timestamp);

try {

    foreach ($numeros as $key => $numero) {
        $sql = "INSERT INTO ordens (numero, id_categorias, id_usuario, id_fornecedor) VALUES ('$numero', '$id_categoria','$id_usuario','$id_fornecedor')";
        $resultado_ordens = mysqli_query($conn, $sql);
        $result_id = mysqli_insert_id($conn);

        if(!$resultado_ordens) throw new Exception();

        $sql = "INSERT INTO statusxordens (id_ordens, status, data) VALUES ('$result_id', '$status', '$data_formatada')";
        $resultado = mysqli_query($conn, $sql);

        if(!$resultado) throw new Exception();
    }

    $data['message'] = "Registro criado com sucesso!";
    $data['status'] = true;
    echo json_encode($data);
} catch(Exception $e) {
    $data['status']  = false;
    $data['message'] = "Erro ao criar registro!";
    echo json_encode($data);
}