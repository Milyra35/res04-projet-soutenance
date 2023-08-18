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
        $name = $xml->player->name;
        //$experience = $xml->player->
        $money = $xml->player->money;
        $energy = $xml->player->maxStamina;
        $health = $xml->player->health;


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

        $this->render('user/game.phtml', []);
    }
}

?>