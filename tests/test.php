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

            if((int) $item->key->int === 3)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isQualityCrops = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 4)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isAnimal = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 5)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isArtisan = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 13)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isSpringForaging = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 14)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isSummerForaging = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 15)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isFallForaging = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 16)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isWinterForaging = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 17)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isConstruction = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 19)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isExoticForaging = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 6)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isRiverFish = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 7)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isLakeFish = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 8)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isOceanFish = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 9)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isNightFishing = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 10)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isSpecialtyFish = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 11)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isCrabPot = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 20)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isBlacksmith = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 21)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isGeologist = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 22)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isAdventurer = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 23)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $is2500 = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 24)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $is5000 = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 25)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $is10000 = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 26)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $is25000 = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 31)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isChef = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 32)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isFieldResearch = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 33)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isEnchanter = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 34)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isDye = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 35)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isFodder = false;
                        break;
                    }
                }
            }

            if((int) $item->key->int === 36)
            {
                foreach($item->value->ArrayOfBoolean->boolean as $bool)
                {
                    if((string) $bool !== 'true')
                    {
                        $isTheMissing = false;
                        break;
                    }
                }
            }
        }
    }
}
var_dump($isTheMissing);



?>