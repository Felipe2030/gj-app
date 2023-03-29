<?php

include_once "dbconfig.php";

// Define o número de itens por página
$itens_por_pagina = 10;

if (isset($_GET['pagina'])) { $pagina_atual = $_GET['pagina'];
} else { $pagina_atual = 1; }

// Define o limite para a busca no banco de dados
$limite_inicial = ($pagina_atual - 1) * $itens_por_pagina;

$sql = "SELECT * FROM usuarios";

// Adiciona a cláusula WHERE para filtrar os resultados com base na busca
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = trim($_GET['busca']);
    $sql .= " WHERE email LIKE '%$busca%'";
}

$sql .= " LIMIT $limite_inicial, $itens_por_pagina";
$result = $conn->query($sql);

foreach ($result as $key => $row) {
    $data[] = $row;
}

$total_itens   = count($data);
$total_paginas = ceil($total_itens / $itens_por_pagina);

$conn->close();


