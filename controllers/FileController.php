<?php

class FileController extends AbstractController {
    private FileManager $fm;

    public function __construct()
    {
        $this->fm = new FileManager();
    }

    // To get a file by its ID
    public function getFileById(int $id)
    {
        $file = $this->fm->getFileById($id);

        return $file;
    }

    // Read the uploaded file to store the informations into the database
    private function readSavedFile($id)
    {
        $file = $this->fm->getFileById($id);
        $fileName = $file->getName();

        // I need to retrieve the file from the user id
        $xml=simplexml_load_file('data/uploadedfile/'.$fileName) or die("Error: Cannot create object");

        // Player Progress
        $name = htmlspecialchars($xml->player->name);
        $money = htmlspecialchars($xml->player->money);
        $health = htmlspecialchars($xml->player->health);
        $energy = htmlspecialchars($xml->player->maxStamina);
        $cat = null;
        $dog = null;
        $isMarried = false;
        $petName = '';
        
        if($xml->player->spouse)
        {
            $isMarried = true;
        }

        // To see if the player has children in the game
        $child = false;
        
        foreach($xml->locations->GameLocation->characters->NPC as $npc)
        {
            if(!empty($npc->idOfParent))
            {
                $child = true;
            }
        }
        
        if($xml->player->catPerson == true)
        {
            $cat = true;
            $dog = false;
        }
        if($xml->player->catPerson == false)
        {
            $cat = false;
            $dog = true;
        }

        foreach($xml->locations->GameLocation as $location)
        {
            foreach($location->characters->NPC as $pet)
            {
                // To access the value of the attribute xsi:type, i had to make sure the xmlns:xsi existed in the XML file
                $type = $pet->attributes('xsi', true)->type;
                if((string) $type === "Cat" || (string) $type === "Dog")
                {
                    $petName = htmlspecialchars($pet->name);
                }
            }
        }
        
        // var_dump($petName);
        $newPlayer = new PlayerProgress($file, $name, $money, $health, $energy, $cat, $dog, $petName, $isMarried, $child);
        $this->pp->addProgress($newPlayer);


        // Player skills
        $farmingLevel = intval($xml->player->farmingLevel);
        $farming = new PlayerSkill($file,"Farming", $farmingLevel);
        
        $miningLevel = intval($xml->player->miningLevel);
        $mining = new PlayerSkill($file, "Mining", $miningLevel);
        
        $combatLevel = intval($xml->player->combatLevel);
        $combat = new PlayerSkill($file, "Combat", $combatLevel);
        
        $foragingLevel = intval($xml->player->foragingLevel);
        $foraging = new PlayerSkill($file, "Foraging", $foragingLevel);
        
        $fishingLevel = intval($xml->player->fishingLevel);
        $fishing = new PlayerSkill($file, "Fishing", $fishingLevel);
        
        $this->psm->addSkill($farming);
        $this->psm->addSkill($mining);
        $this->psm->addSkill($combat);
        $this->psm->addSkill($foraging);
        $this->psm->addSkill($fishing);


        // Statistics
        $hoursPlayed = intval(intval($xml->player->millisecondsPlayed) / 3600000);
        $daysSpent = intval($xml->player->stats->daysPlayed);
        $seasonsPassed = intval(($daysSpent / 28) / 4);
        $fishCaught = intval($xml->player->stats->fishCaught);

        $newStat = new Statistic($file, $hoursPlayed, $daysSpent, $seasonsPassed, $fishCaught);
        $this->sm->addStatistics($newStat);


        // Relationships
        foreach($xml->player->friendshipData->item as $friend)
        {
            $name = htmlspecialchars($friend->key->string);
            
            if($name === "Alex" ||
                $name === "Elliott" || $name === "Harvey" || $name === "Sam" ||
                $name === "Sebastian" || $name === "Shane" || $name === "Abigail" ||
                $name === "Emily" || $name === "Haley" || $name === "Leah" ||
                $name === "Maru" || $name === "Penny" || $name === "Caroline" ||
                $name === "Clint" || $name === "Demetrius" || $name === "Dwarf" ||
                $name === "Evelyn" || $name === "George" || $name === "Gus" ||
                $name === "Jas" || $name === "Jodi" || $name === "Kent" ||
                $name === "Krobus" || $name === "Leo" || $name === "Lewis" ||
                $name === "Linus" || $name === "Marnie" || $name === "Pam" ||
                $name === "Pierre" || $name === "Robin" || $name === "Sandy" ||
                $name === "Vincent" || $name === "Willy" || $name === "Wizard")
            {
                $villager = $this->vm->getVillagerByName($name);
                $friendshipLevel = 0;

                foreach($friend->value->Friendship as $level)
                {
                    $friendshipLevel = intval($level->Points);
                }

                $newRelationship = new Relationship($file, $villager, $friendshipLevel);
                $this->rm->addRelationship($newRelationship);
                // var_dump($newRelationship);
            }
            else
            {
                error_log("Villager does not exist in the database");
            }
        }


        // Possessed Items
        foreach($xml->player->items->Item as $item)
        {
            if($item)
            {
                $name = htmlspecialchars($item->Name);
                $amount = intval($item->Stack);
                $newItem = new PossessedItem($file, $name, $amount);
                $this->pim->addPossessedItem($newItem);
            }
        }


        // Locations
        $isMine = false;
        $isRailroad = false;
        $isQuarry = false;
        $isSkull = false;
        $isSewer = false;
        $isGinger = false;
        $isSummit = false;

        $mine = "Mine";
        $railroad = "Railroad";
        $quarry = "Quarry Mine";
        $skull = "Desert";
        $sewer = "The Sewers";
        $ginger = "Ginger Island";
        $summit = "Summit";

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
            else if((string) $location === "Visited_Island")
            {
                $isGinger = true;
            }
            else if((string) $location === "Summit_event")
            {
                $isSummit = true;
            }
        }

        $newMine = new Location($file, $mine, $isMine);
        $newRailroad = new Location($file, $railroad, $isRailroad);
        $newQuarry = new Location($file, $quarry, $isQuarry);
        $newSkull = new Location($file, $skull, $isSkull);
        $newSewer = new Location($file, $sewer, $isSewer);
        $newGinger = new Location($file, $ginger, $isGinger);
        $newSummit = new Location($file, $summit, $isSummit);

        $this->lm->addLocation($newMine);
        $this->lm->addLocation($newRailroad);
        $this->lm->addLocation($newQuarry);
        $this->lm->addLocation($newSkull);
        $this->lm->addLocation($newSewer);
        $this->lm->addLocation($newGinger);
        $this->lm->addLocation($newSummit);

        
        // Books, i had to change the database for the books because i only had the number of books i obtained in a game
        $amountOfBooks = intval($xml->lostBooksFound);
        $newBook = new Book($file, $amountOfBooks);
        $this->bm->addBook($newBook);

        // Museum
        // I have to declare all of the above as false
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
        // var_dump($isFluorapatite);
        $newHelm = new Museum($file, "Dwarvish Helm", $isHelm);
        $newEarthCrystal = new Museum($file, "Earth Crystal", $isEarthCrystal);
        $newGranite = new Museum($file, "Granite", $isGranite);
        $newThunderEgg = new Museum($file, "Thunder Egg", $isThunderEgg);
        $newAncientDoll = new Museum($file, "Ancient Doll", $isAncientDoll);
        $newOrpiment = new Museum($file, "Orpiment", $isOrpiment);
        $newAmphibianFossil = new Museum($file, "Amphibian Fossil", $isAmphibianFossil);
        $newMudstone = new Museum($file, "Mudstone", $isMudstone);
        $newMalachite = new Museum($file, "Malachite", $isMalachite);
        $newFireOpal = new Museum($file, "Fire Opal", $isFireOpal);
        $newNautilusFossil = new Museum($file, "Nautilus Fossil", $isNautilusFossil);
        $newAerinite = new Museum($file, "Aerinite", $isAerinite);
        $newPetrifiedSlime = new Museum($file, "Petrified Slime", $isPetrifiedSlime);
        $newCelestine = new Museum($file, "Celestine", $isCelestine);
        $newOrnamentalFan = new Museum($file, "Ornamental Fan", $isOrnamentalFan);
        $newDriedStarfish = new Museum($file, "Dried Starfish", $isDriedStarfish);
        $newLunarite = new Museum($file, "Lunarite", $isLunarite);
        $newJagoite = new Museum($file, "Jagoite", $isJagoite);
        $newFairyStone = new Museum($file, "Fairy Stone", $isFairyStone);
        $newOceanStone = new Museum($file, "Ocean Stone", $isOceanStone);
        $newAmethyst = new Museum($file, "Amethyst", $isAmethyst);
        $newJade = new Museum($file, "Jade", $isJade);
        $newQuartz = new Museum($file, "Quartz", $isQuartz);
        $newRuby = new Museum($file, "Ruby", $isRuby);
        $newTopaz = new Museum($file, "Topaz", $isTopaz);
        $newPyrite = new Museum($file, "Pyrite", $isPyrite);
        $newMarble = new Museum($file, "Marble", $isMarble);
        $newFrozenTear = new Museum($file, "Frozen Tear", $isFrozenTear);
        $newJasper = new Museum($file, "Jasper", $isJasper);
        $newSandstone = new Museum($file, "Sandstone", $isSandstone);
        $newDwarfScrollIII = new Museum($file, "Dwarf Scroll III", $isDwarfScrollIII);
        $newFireQuartz = new Museum($file, "Fire Quartz", $isFireQuartz);
        $newNeptunite = new Museum($file, "Neptunite", $isNeptunite);
        $newRustySpur = new Museum($file, "Rusty Spur", $isRustySpur);
        $newCalcite = new Museum($file, "Calcite", $isCalcite);
        $newPrehistoricTool = new Museum($file, "Prehistoric Tool", $isPrehistoricTool);
        $newAquamarine = new Museum($file, "Aquamarine", $isAquamarine);
        $newPrehistoricSkull = new Museum($file, "Prehistoric Skull", $isPrehistoricSkull);
        $newPalmFossil = new Museum($file, "Palm Fossil", $isPalmFossil);
        $newAnchor = new Museum($file, "Anchor", $isAnchor);
        $newDiamond = new Museum($file, "Diamond", $isDiamond);
        $newChickenStatue = new Museum($file, "Chicken Statue", $isChickenStatue);
        $newProhistoricScapula = new Museum($file, "Prohistoric Scapula", $isProhistoricScapula);
        $newPrehistoricHandaxe = new Museum($file, "Prehistoric Handaxe", $isPrehistoricHandaxe);
        $newSkeletalHand = new Museum($file, "Skeletal Hand", $isSkeletalHand);
        $newChippedAmphora = new Museum($file, "Chipped Amphora", $isChippedAmphora);
        $newPrehistoricVertebra = new Museum($file, "Prehistoric Vertebra", $isPrehistoricVertebra);
        $newRustySpoon = new Museum($file, "Rusty Spoon", $isRustySpoon);
        $newJamborite = new Museum($file, "Jamborite", $isJamborite);
        $newAncientSeed = new Museum($file, "Ancient Seed", $isAncientSeed);
        $newAncientDrum = new Museum($file, "Ancient Drum", $isAncientDrum);
        $newPrehistoricRib = new Museum($file, "Prehistoric Rib", $isPrehistoricRib);
        $newRustyCog = new Museum($file, "Rusty Cog", $isRustyCog);
        $newGlassShards = new Museum($file, "Glass Shards", $isGlassShards);
        $newGoldenRelic = new Museum($file, "Golden Relic", $isGoldenRelic);
        $newStrangeDollYellow = new Museum($file, "Strange Doll (yellow)", $isStrangeDollYellow);
        $newStrangeDollGreen = new Museum($file, "Strange Doll (green)", $isStrangeDollGreen);
        $newTrilobite = new Museum($file, "Trilobite", $isTrilobite);
        $newSkeletalTail = new Museum($file, "Skeletal Tail", $isSkeletalTail);
        $newBasalt = new Museum($file, "Basalt", $isBasalt);
        $newStarShards = new Museum($file, "Star Shards", $isStarShards);
        $newGeminite = new Museum($file, "Geminite", $isGeminite);
        $newTigerseye = new Museum($file, "Tigerseye", $isTigerseye);
        $newNekoite = new Museum($file, "Nekoite", $isNekoite);
        $newEmerald = new Museum($file, "Emerald", $isEmerald);
        $newDwarfScrollI = new Museum($file, "Dwarf Scroll I", $isDwarfScrollI);
        $newAlamite = new Museum($file, "Alamite", $isAlamite);
        $newBaryte = new Museum($file, "Baryte", $isBaryte);
        $newAncientSword = new Museum($file, "Ancient Sword", $isAncientSword);
        $newHematite = new Museum($file, "Hematite", $isHematite);
        $newOpal = new Museum($file, "Opal", $isOpal);
        $newSoapstone = new Museum($file, "Soapstone", $isSoapstone);
        $newSlate = new Museum($file, "Slate", $isSlate);
        $newLimestone = new Museum($file, "Limestone", $isLimestone);
        $newDwarfGadget = new Museum($file, "Dwarf Gadget", $isDwarfGadget);
        $newObsidian = new Museum($file, "Obsidian", $isObsidian);
        $newEsperite = new Museum($file, "Esperite", $isEsperite);
        $newGhostCrystal = new Museum($file, "Ghost Crystal", $isGhostCrystal);
        $newArrowhead = new Museum($file, "Arrowhead", $isArrowhead);
        $newHelvite = new Museum($file, "Helvite", $isHelvite);
        $newRareDisc = new Museum($file, "Rare Disc", $isRareDisc);
        $newDolomite = new Museum($file, "Dolomite", $isDolomite);
        $newDwarfScrollIV = new Museum($file, "Dwarf Scroll IV", $isDwarfScrollIV);
        $newDwarfScrollII = new Museum($file, "Dwarf Scroll II", $isDwarfScrollII);
        $newPrismaticShard = new Museum($file, "Prismatic Shard", $isPrismaticShard);
        $newLemonStone = new Museum($file, "Lemon Stone", $isLemonStone);
        $newKyanite = new Museum($file, "Kyanite", $isKyanite);
        $newBoneFlute = new Museum($file, "Bone Flute", $isBoneFlute);
        $newGoldenMask = new Museum($file, "Golden Mask", $isGoldenMask);
        $newDinosaurEgg = new Museum($file, "Dinosaur Egg", $isDinosaurEgg);
        $newPrehistoricTibia = new Museum($file, "Prehistoric Tibia", $isPrehistoricTibia);
        $newBixite = new Museum($file, "Bixite", $isBixite);
        $newFluorapatite = new Museum($file, "Fluorapatite", $isFluorapatite);
        $newChewingStick = new Museum($file, "Chewing Stick", $isChewingStick);
        $newElvishJewelry = new Museum($file, "Elvish Jewelry", $isElvishJewelry);

        $this->mm->addItem($newHelm);
        $this->mm->addItem($newEarthCrystal);
        $this->mm->addItem($newGranite);
        $this->mm->addItem($newThunderEgg);
        $this->mm->addItem($newAncientDoll);
        $this->mm->addItem($newOrpiment);
        $this->mm->addItem($newAmphibianFossil);
        $this->mm->addItem($newMudstone);
        $this->mm->addItem($newMalachite);
        $this->mm->addItem($newFireOpal);
        $this->mm->addItem($newNautilusFossil);
        $this->mm->addItem($newAerinite);
        $this->mm->addItem($newPetrifiedSlime);
        $this->mm->addItem($newCelestine);
        $this->mm->addItem($newOrnamentalFan);
        $this->mm->addItem($newDriedStarfish);
        $this->mm->addItem($newLunarite);
        $this->mm->addItem($newJagoite);
        $this->mm->addItem($newFairyStone);
        $this->mm->addItem($newOceanStone);
        $this->mm->addItem($newAmethyst);
        $this->mm->addItem($newJade);
        $this->mm->addItem($newQuartz);
        $this->mm->addItem($newRuby);
        $this->mm->addItem($newTopaz);
        $this->mm->addItem($newPyrite);
        $this->mm->addItem($newMarble);
        $this->mm->addItem($newFrozenTear);
        $this->mm->addItem($newJasper);
        $this->mm->addItem($newSandstone);
        $this->mm->addItem($newDwarfScrollIII);
        $this->mm->addItem($newFireQuartz);
        $this->mm->addItem($newNeptunite);
        $this->mm->addItem($newRustySpur);
        $this->mm->addItem($newCalcite);
        $this->mm->addItem($newPrehistoricTool);
        $this->mm->addItem($newAquamarine);
        $this->mm->addItem($newPrehistoricSkull);
        $this->mm->addItem($newPalmFossil);
        $this->mm->addItem($newAnchor);
        $this->mm->addItem($newDiamond);
        $this->mm->addItem($newChickenStatue);
        $this->mm->addItem($newProhistoricScapula);
        $this->mm->addItem($newPrehistoricHandaxe);
        $this->mm->addItem($newSkeletalHand);
        $this->mm->addItem($newChippedAmphora);
        $this->mm->addItem($newPrehistoricVertebra);
        $this->mm->addItem($newRustySpoon);
        $this->mm->addItem($newJamborite);
        $this->mm->addItem($newAncientSeed);
        $this->mm->addItem($newAncientDrum);
        $this->mm->addItem($newPrehistoricRib);
        $this->mm->addItem($newRustyCog);
        $this->mm->addItem($newGlassShards);
        $this->mm->addItem($newGoldenRelic);
        $this->mm->addItem($newStrangeDollYellow);
        $this->mm->addItem($newStrangeDollGreen);
        $this->mm->addItem($newTrilobite);
        $this->mm->addItem($newSkeletalTail);
        $this->mm->addItem($newBasalt);
        $this->mm->addItem($newStarShards);
        $this->mm->addItem($newGeminite);
        $this->mm->addItem($newTigerseye);
        $this->mm->addItem($newNekoite);
        $this->mm->addItem($newEmerald);
        $this->mm->addItem($newDwarfScrollI);
        $this->mm->addItem($newAlamite);
        $this->mm->addItem($newBaryte);
        $this->mm->addItem($newAncientSword);
        $this->mm->addItem($newHematite);
        $this->mm->addItem($newOpal);
        $this->mm->addItem($newSoapstone);
        $this->mm->addItem($newSlate);
        $this->mm->addItem($newLimestone);
        $this->mm->addItem($newDwarfGadget);
        $this->mm->addItem($newObsidian);
        $this->mm->addItem($newEsperite);
        $this->mm->addItem($newGhostCrystal);
        $this->mm->addItem($newArrowhead);
        $this->mm->addItem($newHelvite);
        $this->mm->addItem($newRareDisc);
        $this->mm->addItem($newDolomite);
        $this->mm->addItem($newDwarfScrollIV);
        $this->mm->addItem($newDwarfScrollII);
        $this->mm->addItem($newPrismaticShard);
        $this->mm->addItem($newLemonStone);
        $this->mm->addItem($newKyanite);
        $this->mm->addItem($newBoneFlute);
        $this->mm->addItem($newGoldenMask);
        $this->mm->addItem($newDinosaurEgg);
        $this->mm->addItem($newPrehistoricTibia);
        $this->mm->addItem($newBixite);
        $this->mm->addItem($newFluorapatite);
        $this->mm->addItem($newChewingStick);
        $this->mm->addItem($newElvishJewelry);


        // Community Center
        // I initialize them as true and verify if the bundle is complete. If it is, it stays true, otherwise, it's false at the first encounter of a false
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
        // var_dump($isTheMissing);

        $springCrops = new CommunityCenter($file, "Spring Crops", $isSpringCrops);
        $summerCrops = new CommunityCenter($file, "Summer Crops", $isSummerCrops);
        $fallCrops = new CommunityCenter($file, "Fall Crops", $isFallCrops);
        $qualityCrops = new CommunityCenter($file, "Quality Crops", $isQualityCrops);
        $animal = new CommunityCenter($file, "Animal", $isAnimal);
        $artisan = new CommunityCenter($file, "Artisan", $isArtisan);
        $springForaging = new CommunityCenter($file, "Spring Foraging", $isSpringForaging);
        $summerForaging = new CommunityCenter($file, "Summer Foraging", $isSummerForaging);
        $fallForaging = new CommunityCenter($file, "Fall Foraging", $isFallForaging);
        $winterForaging = new CommunityCenter($file, "Winter Foraging", $isWinterForaging);
        $construction = new CommunityCenter($file, "Construction", $isConstruction);
        $exoticForaging = new CommunityCenter($file, "Exotic Foraging", $isExoticForaging);
        $riverFish = new CommunityCenter($file, "River Fish", $isRiverFish);
        $lakeFish = new CommunityCenter($file, "Lake Fish", $isLakeFish);
        $oceanFish = new CommunityCenter($file, "Ocean Fish", $isOceanFish);
        $nightFishing = new CommunityCenter($file, "Night Fishing", $isNightFishing);
        $specialtyFish = new CommunityCenter($file, "Specialty Fish", $isSpecialtyFish);
        $carbPot = new CommunityCenter($file, "Carb Pot", $isCarbPot);
        $blacksmith = new CommunityCenter($file, "Blacksmith", $isBlacksmith);
        $geologist = new CommunityCenter($file, "Geologist", $isGeologist);
        $adventurer = new CommunityCenter($file, "Adventurer", $isAdventurer);
        $bundle2500 = new CommunityCenter($file, "2500", $is2500);
        $bundle5000 = new CommunityCenter($file, "5000", $is5000);
        $bundle10000 = new CommunityCenter($file, "10000", $is10000);
        $bundle25000 = new CommunityCenter($file, "25000", $is25000);
        $chef = new CommunityCenter($file, "Chef", $isChef);
        $fieldResearch = new CommunityCenter($file, "Field Research", $isFieldResearch);
        $enchanter = new CommunityCenter($file, "Enchanter", $isEnchanter);
        $dye = new CommunityCenter($file, "Dye", $isDye);
        $fodder = new CommunityCenter($file, "Fodder", $isFodder);
        $theMissing = new CommunityCenter($file, "The Missing", $isTheMissing);

        $this->ccm->addBundle($springCrops);
        $this->ccm->addBundle($summerCrops);
        $this->ccm->addBundle($fallCrops);
        $this->ccm->addBundle($qualityCrops);
        $this->ccm->addBundle($animal);
        $this->ccm->addBundle($artisan);
        $this->ccm->addBundle($springForaging);
        $this->ccm->addBundle($summerForaging);
        $this->ccm->addBundle($fallForaging);
        $this->ccm->addBundle($winterForaging);
        $this->ccm->addBundle($construction);
        $this->ccm->addBundle($exoticForaging);
        $this->ccm->addBundle($riverFish);
        $this->ccm->addBundle($lakeFish);
        $this->ccm->addBundle($oceanFish);
        $this->ccm->addBundle($nightFishing);
        $this->ccm->addBundle($specialtyFish);
        $this->ccm->addBundle($carbPot);
        $this->ccm->addBundle($blacksmith);
        $this->ccm->addBundle($geologist);
        $this->ccm->addBundle($adventurer);
        $this->ccm->addBundle($bundle2500);
        $this->ccm->addBundle($bundle5000);
        $this->ccm->addBundle($bundle10000);
        $this->ccm->addBundle($bundle25000);
        $this->ccm->addBundle($chef);
        $this->ccm->addBundle($fieldResearch);
        $this->ccm->addBundle($enchanter);
        $this->ccm->addBundle($dye);
        $this->ccm->addBundle($fodder);
        $this->ccm->addBundle($theMissing);
    }

    // To add the file with the form
    public function uploadFile()
    {
        if(isset($_POST['upload-file']))
        {
            // Verify if the file has been uploaded with success
            if(!empty($_FILES['saved-file']) && $_FILES['saved-file']['error'] === UPLOAD_ERR_OK)
            {
                $file = $_FILES['saved-file'];

                // To get the file name
                $fileName = htmlspecialchars($file['name']);
                
                // To move the file to the right path
                $path = 'data/uploadedfile/' . $fileName . '.xml';
                move_uploaded_file($file['tmp_name'], $path);

                $newFile = new SavedFile($_SESSION['user'], $fileName, $path);
                
                $this->fm->addFile($newFile);
                $_SESSION['file_id'] = $newFile->getId();
                
                $this->readSavedFile($_SESSION['file_id']);

                echo "File uploaded with success";
            }
            else
            {
                // var_dump($_FILES);
                // Show the errors if one exists
                if($_FILES['saved-file']['error'] === UPLOAD_ERR_FORM_SIZE)
                {
                    echo "The file exceeds the maximum file size";
                }
                else if($_FILES['saved-file']['error'] === UPLOAD_ERR_PARTIAL)
                {
                    echo "The file could not be uploaded entirely. Try again";
                }
                else
                {
                    var_dump($_FILES['saved-file']['error']);
                    echo "Try again later";
                }
            }
        }
        // else 
        // {
        //     $this->render('staticpages/homepage.phtml', []);
        // }
    }

    // We want the list of the games of a user
    public function indexGames()
    {
        $gamesSaved = $this->fm->getGamesByUser($_SESSION['user_id']);
        $this->render('user/games.phtml', $gamesSaved);
    }


}

?>