<?php



$xmlparser = xml_parser_create();

$fp = fopen("Marpau_269973769", "r");
$xmldata = fread($fp, 600000);

// Parse XML data into an array
xml_parse_into_struct($xmlparser,$xmldata,$values);

xml_parser_free($xmlparser);
print_r($values);
fclose($fp);


?>