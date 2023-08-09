<?php

$xml=simplexml_load_file("Marpau_269973769") or die("Error: Cannot create object");

foreach($xml->player as $value)
{
    echo $value->getName() . ":". $value->name ."<br>";
    echo $value->money . "<br>";

    // foreach($value->professions->int as $level)
    // {
    //     echo $level->getname(). ":" . $level . "<br>";
    // }
    
}
print_r($xml);

?>