<?php

include_once "../../dbconfig.php";
session_start();

$id_usuario = $_SESSION['usuario'];

$status        = isset($_GET['status'])       ? $_GET['status']       : false;
$id_categoria  = isset($_GET['categoria'])    ? $_GET['categoria']    : false;
$id_fornecedor = isset($_GET['fornecedor'])   ? $_GET['fornecedor']   : false;
$data_inicial  = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : false;
$data_termino  = isset($_GET['data_termino']) ? $_GET['data_termino'] : false;

$sql = "SELECT 
    DISTINCT t1.id_ordens, 
    t1.status, 
    t1.data,
    t2.numero,
    t3.nome AS categoria,
    t4.nome AS fornecedor,
    t4.ganho_entrega
FROM statusxordens AS t1
    INNER JOIN ordens AS t2 ON t2.id = t1.id_ordens
    INNER JOIN categorias AS t3 ON t3.id = t2.id_categorias
    INNER JOIN fornecedor AS t4 ON t4.id = t2.id_fornecedor
";

$sql .=" WHERE t1.data >= '$data_inicial' AND t1.data <= '$data_termino' AND t1.status = '$status'";

if(!!$id_categoria)  $sql .= " AND t2.id_categorias = '$id_categoria'"; 
if(!!$id_fornecedor) $sql .= " AND t2.id_fornecedor = '$id_fornecedor'"; 

$sql .=" AND t2.id_usuario = '$id_usuario'";
$sql .=" ORDER BY t1.id_ordens DESC";

$result = $conn->query($sql);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=relatorio.xls');

// Gerar arquivo XML do Excel
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">';
$xml .= '<Worksheet ss:Name="Sheet1">';
$xml .= '<Table>';

// Definir cabeçalhos da tabela
$xml .= '<Row>';
$xml .= '<Cell><Data ss:Type="String">ID</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">NUMERO</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">CATEGORIA</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">FORNECEDOR</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">GANHO</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">STATUS</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">DATA</Data></Cell>';
$xml .= '</Row>';

while ($row = mysqli_fetch_assoc($result)) {
    $xml .= '<Row>';
    $xml .= '<Cell><Data ss:Type="Number">' . $row['id_ordens'] . '</Data></Cell>';
    $xml .= '<Cell><Data ss:Type="String">' . $row['numero'] . '</Data></Cell>';
    $xml .= '<Cell><Data ss:Type="String">' . $row['categoria'] . '</Data></Cell>';
    $xml .= '<Cell><Data ss:Type="String">' . $row['fornecedor'] . '</Data></Cell>';
    $xml .= '<Cell><Data ss:Type="String">' . $row['ganho_entrega'] . '</Data></Cell>';
    $xml .= '<Cell><Data ss:Type="String">' . $row['status'] . '</Data></Cell>';
    $xml .= '<Cell><Data ss:Type="String">' . $row['data'] . '</Data></Cell>';
    $xml .= '</Row>';
}

$xml .= '</Table>';
$xml .= '</Worksheet>';
$xml .= '</Workbook>';

echo $xml;
exit;



