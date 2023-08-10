<?php

require 'services/autoload.php';

session_start();
//var_dump($_SESSION['user_id']);
$router = new Router();
$router->checkRoute();

?>