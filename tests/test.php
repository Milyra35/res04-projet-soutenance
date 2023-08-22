<?php

$xml=simplexml_load_file("Greenfields_351114297") or die("Error: Cannot create object");

$isHelm = false;
$isEarthCrystal = false;
$isGranite = false;
$isThunderEgg = false;
$isAncientDoll = false;
$isOrpiment = false;
$isAmphibianFossil = false;
$isMudstone = false;
$isMalachite = false;
$isFireOpal = false;
$isNautilusFossil = false;
$isAerinite = false;
$isPetrifiedSlime = false;
$isCelestine = false;
$isOrnamentalFan = false;
$isDriedStarfish = false;
$isLunarite = false;
$isJagoite = false;
$isFairyStone = false;
$isOceanStone = false;
$isAmethyst = false;
$isJade = false;
$isQuartz = false;
$isRuby = false;
$isTopaz = false;
$isPyrite = false;
$isMarble = false;
$isFrozenTear = false;
$isJasper = false;
$isSandstone = false;
$isDwarfScrollIII = false;
$isFireQuartz = false;
$isNeptunite = false;
$isRustySpur = false;
$isCalcite = false;
$isPrehistoricTool = false;
$isAquamarine = false;
$isPrehistoricSkull = false;
$isPalmFossil = false;
$isAnchor = false;
$isDiamond = false;
$isChickenStatue = false;
$isPrehistoricScapula = false;
$isPrehistoricHandaxe = false;
$isSkeletalHand = false;
$isChippedAmphora = false;
$isPrehistoricVertebra = false;
$isRustySpoon = false;
$isJamborite = false;
$isAncientSeed = false;
$isAncientDrum = false;
$isPrehistoricRib = false;
$isRustyCog = false;
$isGlassShards = false;
$isGoldenRelic = false;
$isStrangeDollYellow = false;
$isStrangeDollGreen = false;
$isTrilobite = false;
$isSkeletalTail = false;
$isBasalt = false;
$isStarShards = false;
$isGeminite = false;
$isTigerseye = false;
$isNekoite = false;
$isEmerald = false;
$isDwarfScrollI = false;
$isAlamite = false;
$isBaryte = false;
$isAncientSword = false;
$isHematite = false;
$isOpal = false;
$isSoapstone = false;
$isSlate = false;
$isLimestone = false;
$isDwarfGadget = false;
$isObsidian = false;
$isEsperite = false;
$isGhostCrystal = false;
$isArrowhead = false;
$isHelvite = false;
$isRareDisc = false;
$isDolomite = false;
$isDwarfScrollIV = false;
$isDwarfScrollII = false;
$isPrismaticShard = false;
$isLemonStone = false;
$isKyanite = false;
$isBoneFlute = false;
$isGoldenMask = false;
$isDinosaurEgg = false;
$isPrehistoricTibia = false;
$isBixite = false;
$isFluorapatite = false;
$isChewingStick = false;
$isElvishJewelry = false;

foreach($xml->locations->GameLocation as $location)
{
    $type = $location->attributes('xsi', true)->type;

    if((string) $type === "LibraryMuseum")
    {
        foreach($location->museumPieces->item as $item)
        {
            if($item)
            {
                if((int) $item->value->int === 121)
                {
                    $isHelm = true;
                }
                else if((int) $item->value->int === 86)
                {
                    $isEarthCrystal = true;
                }
                else if((int) $item->value->int === 569)
                {
                    $isGranite = true;
                }
                else if((int) $item->value->int === 558)
                {
                    $isThunderEgg = true;
                }
                else if((int) $item->value->int === 103)
                {
                    $isAncientDoll = true;
                }
                else if((int) $item->value->int === 556)
                {
                    $isOrpiment = true;
                }
                else if((int) $item->value->int === 587)
                {
                    $isAmphibianFossil = true;
                }
                else if((int) $item->value->int === 574)
                {
                    $isMudstone = true;
                }
                else if((int) $item->value->int === 552)
                {
                    $isMalachite = true;
                }
                else if((int) $item->value->int === 565)
                {
                    $isFireOpal = true;
                }
                else if((int) $item->value->int === 586)
                {
                    $isNautilusFossil = true;
                }
                else if((int) $item->value->int === 541)
                {
                    $isAerinite = true;
                }
                else if((int) $item->value->int === 557)
                {
                    $isPetrifiedSlime = true;
                }
                else if((int) $item->value->int === 566)
                {
                    $isCelestine = true;
                }
                else if((int) $item->value->int === 106)
                {
                    $isOrnamentalFan = true;
                }
                else if((int) $item->value->int === 116)
                {
                    $isDriedStarfish = true;
                }
                else if((int) $item->value->int === 551)
                {
                    $isLunarite = true;
                }
                else if((int) $item->value->int === 549)
                {
                    $isJagoite = true;
                }
                else if((int) $item->value->int === 577)
                {
                    $isFairyStone = true;
                }
                else if((int) $item->value->int === 560)
                {
                    $isOceanStone = true;
                }
                else if((int) $item->value->int === 66)
                {
                    $isAmethyst = true;
                }
                else if((int) $item->value->int === 70)
                {
                    $isJade = true;
                }
                else if((int) $item->value->int === 80)
                {
                    $isQuartz = true;
                }
                else if((int) $item->value->int === 64)
                {
                    $isRuby = true;
                }
                else if((int) $item->value->int === 68)
                {
                    $isTopaz = true;
                }
                else if((int) $item->value->int === 559)
                {
                    $isPyrite = true;
                }
                else if((int) $item->value->int === 567)
                {
                    $isMarble = true;
                }
                else if((int) $item->value->int === 84)
                {
                    $isFrozenTear = true;
                }
                else if((int) $item->value->int === 563)
                {
                    $isJasper = true;
                }
                else if((int) $item->value->int === 568)
                {
                    $isSandstone = true;
                }
                else if((int) $item->value->int === 98)
                {
                    $isDwarfScrollIII = true;
                }
                else if((int) $item->value->int === 82)
                {
                    $isFireQuartz = true;
                }
                else if((int) $item->value->int === 553)
                {
                    $isNeptunite = true;
                }
                else if((int) $item->value->int === 111)
                {
                    $isRustySpur = true;
                }
                else if((int) $item->value->int === 542)
                {
                    $isCalcite = true;
                }
                else if((int) $item->value->int === 115)
                {
                    $isPrehistoricTool = true;
                }
                else if((int) $item->value->int === 62)
                {
                    $isAquamarine = true;
                }
                else if((int) $item->value->int === 581)
                {
                    $isPrehistoricSkull = true;
                }
                else if((int) $item->value->int === 588)
                {
                    $isPalmFossil = true;
                }
                else if((int) $item->value->int === 117)
                {
                    $isAnchor = true;
                }
                else if((int) $item->value->int === 72)
                {
                    $isDiamond = true;
                }
                else if((int) $item->value->int === 113)
                {
                    $isChickenStatue = true;
                }
                else if((int) $item->value->int === 579)
                {
                    $isProhistoricScapula = true;
                }
                else if((int) $item->value->int === 120)
                {
                    $isPrehistoricHandaxe = true;
                }
                else if((int) $item->value->int === 582)
                {
                    $isSkeletalHand = true;
                }
                else if((int) $item->value->int === 100)
                {
                    $isChippedAmphora = true;
                }
                else if((int) $item->value->int === 584)
                {
                    $isPrehistoricVertebra = true;
                }
                else if((int) $item->value->int === 110)
                {
                    $isRustySpoon = true;
                }
                else if((int) $item->value->int === 548)
                {
                    $isJamborite = true;
                }
                else if((int) $item->value->int === 114)
                {
                    $isAncientSeed = true;
                }
                else if((int) $item->value->int === 123)
                {
                    $isAncientDrum = true;
                }
                else if((int) $item->value->int === 583)
                {
                    $isPrehistoricRib = true;
                }
                else if((int) $item->value->int === 112)
                {
                    $isRustyCog = true;
                }
                else if((int) $item->value->int === 118)
                {
                    $isGlassShards = true;
                }
                else if((int) $item->value->int === 125)
                {
                    $isGoldenRelic = true;
                }
                else if((int) $item->value->int === 127)
                {
                    $isStrangeDollYellow = true;
                }
                else if((int) $item->value->int === 126)
                {
                    $isStrangeDollGreen = true;
                }
                else if((int) $item->value->int === 589)
                {
                    $isTrilobite = true;
                }
                else if((int) $item->value->int === 585)
                {
                    $isSkeletalTail = true;
                }
                else if((int) $item->value->int === 570)
                {
                    $isBasalt = true;
                }
                else if((int) $item->value->int === 578)
                {
                    $isStarShards = true;
                }
                else if((int) $item->value->int === 546)
                {
                    $isGeminite = true;
                }
                else if((int) $item->value->int === 562)
                {
                    $isTigerseye = true;
                }
                else if((int) $item->value->int === 555)
                {
                    $isNekoite = true;
                }
                else if((int) $item->value->int === 60)
                {
                    $isEmerald = true;
                }
                else if((int) $item->value->int === 96)
                {
                    $isDwarfScrollI = true;
                }
                else if((int) $item->value->int === 538)
                {
                    $isAlamite = true;
                }
                else if((int) $item->value->int === 540)
                {
                    $isBaryte = true;
                }
                else if((int) $item->value->int === 109)
                {
                    $isAncientSword = true;
                }
                else if((int) $item->value->int === 573)
                {
                    $isHematite = true;
                }
                else if((int) $item->value->int === 564)
                {
                    $isOpal = true;
                }
                else if((int) $item->value->int === 572)
                {
                    $isSoapstone = true;
                }
                else if((int) $item->value->int === 576)
                {
                    $isSlate = true;
                }
                else if((int) $item->value->int === 571)
                {
                    $isLimestone = true;
                }
                else if((int) $item->value->int === 122)
                {
                    $isDwarfGadget = true;
                }
                else if((int) $item->value->int === 575)
                {
                    $isObsidian = true;
                }
                else if((int) $item->value->int === 544)
                {
                    $isEsperite = true;
                }
                else if((int) $item->value->int === 561)
                {
                    $isGhostCrystal = true;
                }
                else if((int) $item->value->int === 101)
                {
                    $isArrowhead = true;
                }
                else if((int) $item->value->int === 547)
                {
                    $isHelvite = true;
                }
                else if((int) $item->value->int === 108)
                {
                    $isRareDisc = true;
                }
                else if((int) $item->value->int === 543)
                {
                    $isDolomite = true;
                }
                else if((int) $item->value->int === 99)
                {
                    $isDwarfScrollIV = true;
                }
                else if((int) $item->value->int === 97)
                {
                    $isDwarfScrollII = true;
                }
                else if((int) $item->value->int === 74)
                {
                    $isPrismaticShard = true;
                }
                else if((int) $item->value->int === 554)
                {
                    $isLemonStone = true;
                }
                else if((int) $item->value->int === 550)
                {
                    $isKyanite = true;
                }
                else if((int) $item->value->int === 119)
                {
                    $isBoneFlute = true;
                }
                else if((int) $item->value->int === 124)
                {
                    $isGoldenMask = true;
                }
                else if((int) $item->value->int === 107)
                {
                    $isDinosaurEgg = true;
                }
                else if((int) $item->value->int === 580)
                {
                    $isPrehistoricTibia = true;
                }
                else if((int) $item->value->int === 539)
                {
                    $isBixite = true;
                }
                else if((int) $item->value->int === 545)
                {
                    $isFluorapatite = true;
                }
                else if((int) $item->value->int === 105)
                {
                    $isChewingStick = true;
                }
                else if((int) $item->value->int === 104)
                {
                    $isElvishJewelry = true;
                }
            }
        }
    }
}
var_dump($isElvishJewelry, $isHelm, $isChewingStick);



?>