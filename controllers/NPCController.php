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
        $txtContent = file_get_contents('../data/villagers.txt');
        $json = $this->toJson($txtContent);
        $data = json_decode($json);

        foreach($data as $villager)
        {
            $name = $villager['name'];
            $love = $villager['loves'];
            $like = $villager['likes'];
            $neutral = $villager['neutral'];
            $dislike = $villager['dislikes'];
            $hate = $villager['hates'];
            $birthday = $villager['birthday'];
            $events = $villager['events'];
            $isDatable = $villager['is_datable'];
            $picture = $this->pm->getPictureById();

            $newVillager = new Villager($name, $love, $like, $neutral, $dislike, $hate, $isDatable, $birthday, $events, $picture);
            $this->vm->addVillager($newVillager);
        }
    }
}

?>