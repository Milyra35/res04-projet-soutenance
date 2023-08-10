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
}

?>