<?php

require 'services/autoload.php';

session_start();
//var_dump($_SESSION['user_id']);
$router = new Router();

if(isset($_GET['path']))
{
    $router->checkRoute($_GET['path']);
}
else
{
    $router->checkRoute("");
}

?>