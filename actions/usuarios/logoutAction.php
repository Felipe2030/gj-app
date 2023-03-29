<?php

session_start();
if(isset($_SESSION['usuario'])):
    session_destroy();
    $data['status']  = true;
    echo json_encode($data);
    exit;
endif;