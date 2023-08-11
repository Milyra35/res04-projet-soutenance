<?php

class Router {
    // Put the controllers in the attributes
    private UserController $uc;
    private ProgressBoardController $pbc;
    private NPCController $npc;
    private MediaController $mc;
    private ItemController $ic;
    private FileController $fc;
    private StaticPageController $spc;
    private AdminController $ac;

    public function __construct()
    {
        // Put the controllers here
        $this->uc = new UserController();
        $this->pbc = new ProgressBoardController();
        $this->npc = new NPCController();
        $this->mc = new MediaController();
        $this->ic = new ItemController();
        $this->fc = new FileController();
        $this->spc = new StaticPageController();
        $this->ac = new AdminController();
    }

    // Create a method to check the routes
    public function checkRoute()
    {
        if(isset($_GET['route']))
        {
            if($_GET['route'] === "homepage")
            {
                $this->spc->render("staticpages/homepage.phtml", []);
                $this->fc->uploadFile();
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
                $this->uc->account();
            }
            else if($_GET['route'] === "my-account/edit" && isset($_SESSION['user']))
            {
                $this->uc->editUser();
            }
            else if($_GET['route'] === "my-account/delete" && isset($_SESSION['user']))
            {
                $this->uc->deleteUser();
            }
            else if($_GET['route'] === "my-games" && isset($_SESSION['user']))
            {
                $this->fc->indexGames();
            }
            else if($_GET['route'] === "logout")
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
                $this->npc->displayVillagerData($villager_id);
            }
            else if($_GET['route'] === "confidentiality")
            {
                $this->spc->render("staticpages/confidentiality.phtml", []);
            }
            else if($_GET['route'] === "legal-notices")
            {
                $this->spc->render("staticpages/legal-notices.phtml", []);
            }
            else if($_GET['route'] === "credits")
            {
                $this->spc->render("staticpages/credits.phtml", []);
            }
            else if($_GET['route'] === "admin" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->ac->index();

                if($_GET['route'] === "admin/all-users")
                {
                    $this->uc->getAllUsers();
                }
                else if($_GET['route'] === "admin/all-saved-games")
                {
                    $this->ac->getAllGames();
                }
                else if($_GET['route'] === "admin/delete")
                {
                    $this->uc->deleteUser();
                    //Delete the user without rendering the delete form for the front part
                }
                else if($_GET['route'] === "admin/statistics")
                {
                    $this->ac->displayStatistics();
                }
                else if($_GET['route'] === "admin/edit")
                {
                    $this->ac->edit();
                }
            }
        }
        else
        {
            $this->spc->render("staticpages/homepage.phtml", []);
        }
    }
}

?>