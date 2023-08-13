<?php

$txtContent = file_get_contents('../data/villagers.txt');
$json = json_encode($txtContent);
$data = json_decode($json);
var_dump($jsonObject);
?>