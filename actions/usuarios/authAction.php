<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

if(!isset($_SESSION['usuario'])):
    session_destroy();
    header('Location: ./index.php');
    exit;
endif;