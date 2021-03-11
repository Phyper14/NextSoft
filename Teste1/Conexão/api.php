<?php
include('conection.php');

if(!array_key_exists('usuarios', $_GET))
{
    echo 'Error. Path missing.';
    exit;
}

$path = explode('/', $_GET['usuarios']);
if(count($path) == 0 || $path[0] == "")
{
    echo 'Error. Path missing.';
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];


if($method === 'GET'){
    
    $selectQuery = "select * from usuarios where cpf = '${}'";
}