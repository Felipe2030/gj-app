<?php

include_once "dbconfig.php";

$id_usuario = $_SESSION['usuario'];

$sql = "SELECT 
    t1.id,
    t1.id_categorias,
    t1.id_fornecedor,
    t1.id_usuario,
    t1.numero,
    t2.nome AS nome_categoria,
    t3.nome AS nome_fornecedor,
    t3.ganho_entrega
FROM ordens AS t1
INNER JOIN categorias AS t2 ON t2.id = t1.id_categorias
INNER JOIN fornecedor AS t3 ON t3.id = t1.id_fornecedor
WHERE t1.id_usuario = '$id_usuario'";

$result = $conn->query($sql);

foreach ($result as $key => $row) {
    $id  = $row['id'];
    $sql = "SELECT * FROM statusxordens WHERE id_ordens = '$id' AND status = 'Concluido' ORDER BY id DESC LIMIT 1";
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


$total_itens = (isset($data)) ? count($data) : 0;

if(isset($data)){
    foreach ($data as $key => $value) {
        $total_ganhos  += $value['ganho_entrega'];
    }
} else {
    $total_ganhos = 0.00;
}

