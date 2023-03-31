<?php

include_once "../../dbconfig.php";

$id    = isset($_GET['id']) ? $_GET['id'] : false;
$sql = "SELECT * FROM ordens WHERE id='$id'";
$resultado = mysqli_query($conn, $sql);

foreach ($resultado as $key => $row) {
    $id  = $row['id'];
    $sql = "SELECT * FROM statusxordens WHERE id_ordens = '$id' ORDER BY id DESC LIMIT 1";
    $result_orden = mysqli_fetch_assoc($conn->query($sql));
    
    $row['status'] = $result_orden['status'];
    $row['data']   = $result_orden['data'];
    $data[] = $row;
}

$data['status'] = true;
echo json_encode($data[0]);

