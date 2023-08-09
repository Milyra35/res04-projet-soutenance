<?php

class Router {
    // Put the controllers in the attributes
    private UserController $uc;
    private ProgressBoardController $pbc;
    private NPCController $npc;
    private MediaController $mc;
    private ItemController $ic;
    private FileController $fc;
    private HomeController $hc;

    public function __construct()
    {
        // Put the controllers here
        $this->uc = new UserController();
        $this->pbc = new ProgressBoardController();
        $this->npc = new NPCController();
        $this->mc = new MediaController();
        $this->ic = new ItemController();
        $this->fc = new FileController();
        $this->hc = new HomeController();
    }

    // Create a method to check the routes
    public function checkRoute()
    {
        if(isset($_GET['route']))
        {
            if($_GET['route'] === "homepage")
            {
                $this->hc->render("homepage/homepage.phtml", []);
            }
            else if($_GET['route'] === "login")
            {
                $this->uc->loadUser();
            }
            else if($_GET['route'] === "register")
            {
                $this->uc->createUser();
            }
            else if($_GET['route'] === "my-account" && isset($_SESSION['user']))
            {

            }
            else if($_GET['route'] === "edit" && isset($_SESSION['user']))
            {
                $this->uc->editUser();
            }
            else if($_GET['route'] === "delete" && isset($_SESSION['user']))
            {
                $this->uc->deleteUser();
            }
            else if($_GET['route'] === "my-games" && isset($_SESSION['user']))
            {

            }
            else if($_GET['route'] === "log-out")
            {
                $this->uc->logoutUser();
            }
            else if($_GET['route'] === "villagers")
            {
                $this->npc->index();
            }
            else if(str_contains($_GET['route'], "villager_id"))
            {
                list($route, $villager_id) = explode("=", $_GET['route']);
                $_SESSION['villager_id'] = $villager_id;
                $this->npc->getVillagerById($villager_id);
            }
            else if($_GET['route'] === "confidentiality")
            {

            }
            else if($_GET['route'] === "legal-notices")
            {

            }
            else if($_GET['route'] === "credits")
            {

            }
            else if($_GET['route'] === "admin" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                
            }
        }
        else
        {
            $this->hc->render("homepage/homepage.phtml", []);
        }
    }
}

?>