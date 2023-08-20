<?php

$xml=simplexml_load_file("Marpau_269973769") or die("Error: Cannot create object");

$isMarried = false;
$spouse = null;

foreach($xml->player->friendshipData->item as $friend)
{
    if(!empty($friend->value->Friendship->WeddingDate))
    {
        $spouse = $friend->key;
        if($spouse)
        {
            $isMarried = true;
        }
    }
    // else
    // {
    //     $isMarried = false;
    // }
}
var_dump($isMarried);

?>