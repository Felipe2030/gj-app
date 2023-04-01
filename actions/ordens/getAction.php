<?php

include_once "dbconfig.php";

$id_usuario = $_SESSION['usuario'];

$sqlFornecedor = "SELECT * FROM fornecedor WHERE id_usuario = '$id_usuario'";
$resultadoFornecedor = mysqli_query($conn, $sqlFornecedor);

while($row = mysqli_fetch_assoc($resultadoFornecedor)){
    $fornecedores[] = $row;
}

$sqlCategirias = "SELECT * FROM categorias WHERE id_usuario = '$id_usuario'";
$resultadoCategorias = mysqli_query($conn, $sqlCategirias);

while($row = mysqli_fetch_assoc($resultadoCategorias)){
    $categirias[] = $row;
}


// Define o número de itens por página
$itens_por_pagina = 10;

if (isset($_GET['pagina'])) { $pagina_atual = $_GET['pagina'];
} else { $pagina_atual = 1; }

// Define o limite para a busca no banco de dados
$limite_inicial = ($pagina_atual - 1) * $itens_por_pagina;

$sql = "SELECT 
    t1.id,
    t1.id_categorias,
    t1.id_fornecedor,
    t1.id_usuario,
    t1.numero,
    t2.nome AS nome_categoria,
    t3.nome AS nome_fornecedor 
FROM ordens AS t1
INNER JOIN categorias AS t2 ON t2.id = t1.id_categorias
INNER JOIN fornecedor AS t3 ON t3.id = t1.id_fornecedor";

// Adiciona a cláusula WHERE para filtrar os resultados com base na busca
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = trim($_GET['busca']);
    $sql .= " WHERE t1.numero LIKE '%$busca%' OR t2.nome LIKE '%$busca%' OR t3.nome LIKE '%$busca%' AND t1.id_usuario = '$id_usuario'";
}else{
    $sql .= " WHERE t1.id_usuario = '$id_usuario'";
}

$sql .= " ORDER BY t1.id DESC";
$sql .= " LIMIT $limite_inicial, $itens_por_pagina";
$result = $conn->query($sql);

foreach ($result as $key => $row) {
    $id  = $row['id'];
    $sql = "SELECT * FROM statusxordens WHERE id_ordens = '$id' ORDER BY id DESC LIMIT 1";
    $result_orden = mysqli_fetch_assoc($conn->query($sql));
    
    $row['status'] = $result_orden['status'];
    $row['data']   = $result_orden['data'];
    $data[] = $row;
}

$sql = "SELECT count(*) as total FROM ordens WHERE id_usuario = '$id_usuario'";
$result_total = mysqli_fetch_assoc($conn->query($sql));

$total_itens   = $result_total["total"];
$total_paginas = ceil($total_itens / $itens_por_pagina);

$conn->close();


