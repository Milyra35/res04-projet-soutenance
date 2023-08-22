<?php

$xml=simplexml_load_file("Greenfields_351114297") or die("Error: Cannot create object");

$isSpringCrops = true;
$isSummerCrops = true;
$isFallCrops = true;
$isQualityCrops = true;
$isAnimal = true;
$isArtisan = true;
$isSpringForaging = true;
$isSummerForaging = true;
$isFallForaging = true;
$isWinterForaging = true;
$isConstruction = true;
$isExoticForaging = true;
$isRiverFish = true;
$isLakeFish = true;
$isOceanFish = true;
$isNightFishing = true;
$isSpecialtyFish = true;
$isCarbPot = true;
$isBlacksmith = true;
$isGeologist = true;
$isAdventurer = true;
$is2500 = true;
$is5000 = true;
$is10000 = true;
$is25000 = true;
$isChef = true;
$isFieldResearch = true;
$isEnchanter = true;
$isDye = true;
$isFodder = true;
$isTheMissing = true;

foreach($xml->locations->GameLocation as $location)
{
    $type = $location->attributes('xsi', true)->type;
    if((string) $type === "CommunityCenter")
    {
        foreach($location->bundles->item as $item)
        {
            if((int) $item->key->int === 0)
            {
                foreach ($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isSpringCrops = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 1)
            {
                foreach ($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isSummerCrops = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 2)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isFallCrops = false;
                        break;
                    }
                }
            }
        }
    }
}
var_dump($isSpringCrops, $isSummerCrops, $isFallCrops);



?>