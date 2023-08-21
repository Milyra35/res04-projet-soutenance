<?php

$xml=simplexml_load_file("Greenfields_351114297") or die("Error: Cannot create object");

$isMine = false;
$isRailroad = false;
$isQuarry = false;
$isSkull = false;
$isSewer = false;

$mine = "Mine";
$railroad = "Railroad";
$quarry = "Quarry Mine";
$skull = "Desert";
$sewer = "The Sewers";

foreach($xml->player->mailReceived->string as $location)
{
    if((string) $location === "checkedMonsterBoard")
    {
        $isMine = true;
    }
    else if((string) $location === "TH_Railroad")
    {
        $isRailroad = true;
    }
    else if((string) $location === "VisitedQuarryMine")
    {
        $isQuarry = true;
    }
    else if((string) $location === "skullCave")
    {
        
        $isSkull = true;
    }
    else if((string) $location === "OpenedSewer")
    {
        $isSewer = true;
    }
}
var_dump($isMine, $isRailroad, $isQuarry, $isSkull, $isSewer);



?>