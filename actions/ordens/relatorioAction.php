<?php

// Conectar ao banco de dados
include_once "../../dbconfig.php";

session_start();

$id_usuario = $_SESSION['usuario'];

// Selecionar dados do banco de dados
$sql = "SELECT * FROM ordens WHERE id_usuario='$id_usuario'";
$result = mysqli_query($conn, $sql);

// Definir cabeçalhos do arquivo Excel
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
$xml .= '<Cell><Data ss:Type="String">STATUS</Data></Cell>';
$xml .= '<Cell><Data ss:Type="String">DATA</Data></Cell>';
$xml .= '</Row>';

// Selecionar dados do banco de dados
while ($row = mysqli_fetch_assoc($result)) {
    $id_ordem = $row['id'];
    $sql = "SELECT * FROM statusxordens WHERE id_ordens='$id_ordem'";
    $result_status_ordens = mysqli_query($conn, $sql);

    while ($row_status = mysqli_fetch_assoc($result_status_ordens)) {
        $xml .= '<Row>';
        $xml .= '<Cell><Data ss:Type="Number">' . $row['id'] . '</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . $row['numero'] . '</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . $row['categorias'] . '</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . $row_status['status'] . '</Data></Cell>';
        $xml .= '<Cell><Data ss:Type="String">' . $row_status['data'] . '</Data></Cell>';
        $xml .= '</Row>';
    }

    $xml .= '<Row>';
    $xml .= '</Row>';
}

// Fechar arquivo XML do Excel
$xml .= '</Table>';
$xml .= '</Worksheet>';
$xml .= '</Workbook>';

// Saída do arquivo XML para o navegador
echo $xml;
exit;
