<?php

include_once "dbconfig.php";

$id_usuario = $_SESSION['usuario'];

$sql = "SELECT * FROM ordens ORDER BY id DESC";
$result = $conn->query($sql);

foreach ($result as $key => $row) {
    $id  = $row['id'];
    $sql = "SELECT * FROM statusxordens WHERE id_ordens = '$id' AND status = 'Concluido' ORDER BY id ASC LIMIT 1";
    $result_orden  = mysqli_fetch_assoc($conn->query($sql));
    $row['status'] = $result_orden['status'];
    $row['data']   = $result_orden['data'];
    $mes           = date("m", strtotime($row['data']));
    $status_filtro = false;

    if (isset($_GET['busca']) && !empty($_GET['busca'])) {
        $busca = trim($_GET['busca']);
        if($busca == $mes) $status_filtro = true;
    }else{
        if($mes == date('m')) $status_filtro = true;
    }

    if($status_filtro) $data[] = $row;
}

$total_itens   = (!!$data) ? count($data) : 0;
$total_ganhos  = (!!$data) ? count($data) * 2.00 : 0.00;
$conn->close();


