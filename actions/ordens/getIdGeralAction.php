<?php

include_once "../../dbconfig.php";

$id    = isset($_GET['id']) ? $_GET['id'] : false;
$sql = "SELECT * FROM ordens as t1 INNER JOIN statusxordens as t2 ON t2.id_ordens = t1.id WHERE t1.id='$id'";
$resultado = mysqli_query($conn, $sql);

foreach ($resultado as $key => $row) {
    $id_categorias = $row['id_categorias'];
    $sqlCategorias = "SELECT * FROM categorias WHERE id='$id_categorias'";
    $result_categorias = mysqli_fetch_assoc($conn->query($sqlCategorias));

    $id_fornecedor = $row['id_fornecedor'];
    $sqlFornecedor = "SELECT * FROM fornecedor WHERE id='$id_fornecedor'";
    $result_fornecedor = mysqli_fetch_assoc($conn->query($sqlFornecedor));

    $row['fornecedor'] = $result_fornecedor['nome'];
    $row['categoria']  = $result_categorias['nome'];
    $data[] = $row;
}

echo json_encode($data);

