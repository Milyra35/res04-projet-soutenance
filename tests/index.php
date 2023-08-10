<?php

$txtContent = file_get_contents('../data/villagers.txt');
$jsonContent = json_encode($txtContent, JSON_PRETTY_PRINT);
var_dump($jsonContent);
?>