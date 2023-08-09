<?php

session_start();

require 'services/autoload.php';

$router = new Router();
$router->checkRoute();

?>