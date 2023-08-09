<?php

$file = file_get_contents('Marpau_269973769');

$xml = new SimpleXMLElement($file);
var_dump($xml);

?>