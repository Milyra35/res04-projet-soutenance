<?php

class ProgressBoardController extends AbstractController {
    private BookManager $bm;
    private CommunityCenterManager $ccm;
    private FileManager $fm;
    private ItemManager $im;
    private LocationManager $lm;
    private MuseumManager $mm;
    private UserManager $um;
    private PlayerProgressManager $pp;
    private PlayerSkillManager $psm;
    private PossessedItemManager $pim;
    private RelationshipManager $rm;
    private StatisticManager $sm;
    private PictureManager $pm;

    public function __construct()
    {
        $this->bm = new BookManager();
        $this->ccm = new CommunityCenterManager();
        $this->fm = new FileManager();
        $this->im = new ItemManager();
        $this->lm = new LocationManager();
        $this->mm = new MuseumManager();
        $this->um = new UserManager();
        $this->pp = new PlayerProgressManager();
        $this->psm = new PlayerSkillManager();
        $this->pim = new PossessedItemManager();
        $this->rm = new RelationShipManager();
        $this->sm = new StatisticManager();
        $this->pm = new PictureManager();
    }

    // Read the uploaded file to store the informations into the database
    public function readSavedFile($id)
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
    }

    public function displayProgress(int $id)
    {
        // I retrieve the skills
        $skills = $this->psm->getSkillsByFile($id);

        // I retrieve the player progress

        // I retrieve the bundles

        // I retrieve the items of the museum

        // I retrieve the statistics

        // I retrieve the books

        // I retrieve the locations

        // I retrieve the possessed items

        // I retrieve the relationships

        $this->render('user/game.phtml', []);
    }
}

?>