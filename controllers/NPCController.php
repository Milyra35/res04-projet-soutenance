<?php

class NPCController extends AbstractController {
    private VillagerManager $vm;
    private VillagerPlanningManager $vpm;
    private PictureManager $pm;

    public function __construct()
    {
        $this->vm = new VillagerManager();
        $this->vpm = new VillagerPlanningManager();
        $this->pm = new PictureManager();
    }

    // Render all the villagers on the villagers' page
    public function index()
    {
        $villagers=$this->vm->getAllVillagers();
        $this->render('villagers/index.phtml', $villagers);
    }

    public function getVillagerById(int $id)
    {
        $villager=$this->vm->getVillagerById($id);
        $_SESSION['villager'] = $villager;

        return $villager;
    }

    // I want to display all the villager's data on one page
    public function displayVillagerData(int $id)
    {
        $villager = $this->getVillagerById($id);
        $this->render('villagers/villager.phtml', ['villager' => $villager]);
    }

    public function addVillagers()
    {
        $txtContent = file_get_contents('data/villagers.txt');
        // $json = null;
        $data = json_decode($txtContent);
        // var_dump($txtContent);
        // var_dump($data);

        foreach($data as $villager)
        {
            $name = $villager->name;
            $love = $villager->loves;
            $like = $villager->likes;
            $neutral = $villager->neutral;
            $dislike = $villager->dislikes;
            $hate = $villager->hates;
            $birthday = $villager->birthday;
            $events = get_object_vars($villager->events);
            $isDatable = $villager->{'is datable'};
            $picture = $this->pm->getPictureByName($name);

            $newVillager = new Villager($name, $love, $like, $neutral, $dislike, $hate, $isDatable, $birthday, $events, $picture);
            // $json=$newVillager;
            $this->vm->addVillager($newVillager);
            // var_dump($villager->loves);
        }
    }

    // To add the schedule of a villager
    public function addVillagerPlanning()
    {
        $txtContent = file_get_contents('data/villagers.txt');
        $data = json_decode($txtContent);

        foreach($data as $planning)
        {
            $villager = $this->vm->getVillagerByName($planning->name);
            $schedule = get_object_vars($planning->schedule);

            $newSchedule = new VillagerPlanning($villager, $schedule);

            $this->vpm->addPlanning($newSchedule);
        }
    }
}

?>