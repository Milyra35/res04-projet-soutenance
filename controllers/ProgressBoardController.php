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
    private VillagerManager $vm;

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
        $this->vm = new VillagerManager();
    }

    public function displayProgress(int $id)
    {
        // I retrieve the skills
        $skills = $this->psm->getSkillsByFile($id);

        // I retrieve the player progress
        $player = $this->pp->getProgressById($id);

        // I retrieve the bundles
        $bundles = $this->ccm->getBundlesByFile($id);
        
        // I retrieve the items of the museum
        $items = $this->mm->getMuseumItemsByFile($id);

        // I retrieve the statistics
        $stats = $this->sm->getStatByFile($id);
        
        // I retrieve the books
        $books = $this->bm->getBookByFile($id);

        // I retrieve the locations
        $locations = $this->lm->getAllLocationsByFile($id);

        // I retrieve the possessed items
        $possessedItems = $this->pim->getItemsFromFile($id);

        // I retrieve the relationships
        $relationships = $this->rm->getRelationshipsByFile($id);

        // I retrieve the items to display them with their pictures if needed
        $itemsPictures;

        // var_dump($relationships);
        $this->render('user/game.phtml', ["skills" => $skills, 
            "player" => $player, 
            "bundles" => $bundles, 
            "items" => $items, 
            "stats" => $stats, 
            "books" => $books, 
            "locations" => $locations, 
            "possessedItems" => $possessedItems, 
            "relationships" => $relationships]);
    }
}

?>