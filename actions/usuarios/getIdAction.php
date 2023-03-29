<?php

include_once "../../dbconfig.php";

$id    = isset($_GET['id']) ? $_GET['id'] : false;
$sql = "SELECT * FROM usuarios WHERE id='$id'";
$resultado = mysqli_query($conn, $sql);

$data['status'] = true;
echo json_encode(mysqli_fetch_assoc($resultado));

