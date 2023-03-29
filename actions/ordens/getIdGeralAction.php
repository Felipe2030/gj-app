<?php

include_once "../../dbconfig.php";

$id    = isset($_GET['id']) ? $_GET['id'] : false;
$sql = "SELECT * FROM ordens as t1 INNER JOIN statusxordens as t2 ON t2.id_ordens = t1.id WHERE t1.id='$id'";
$resultado = mysqli_query($conn, $sql);

foreach ($resultado as $key => $row) {
    $data[] = $row;
}

echo json_encode($data);

