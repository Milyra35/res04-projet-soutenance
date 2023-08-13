<?php

class NPCController extends AbstractController {
    private VillagerManager $vm;

    public function __construct()
    {
        $this->vm = new VillagerManager();
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
}

?>