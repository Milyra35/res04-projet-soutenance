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

    // To create a nice URL
    private function splitRouteAndParameters(string $route) : array
    {
        $routeAndParams = [];
        $routeAndParams['route'] = null;
        $routeAndParams['villagerSlug'] = null;
        $routeAndParams['fileSlug'] = null;
        $routeAndParams['userSlug'] = null;
        $routeAndParams['adminSlug'] = null;


        if(strlen($route) > 0) // If not empty
        {
            $tab = explode("/", $route);

            if($tab[0] === "villagers") // If route begins by villagers
            {
                $routeAndParams['route'] = "villagers"; // I save the value in the array
                if(isset($tab[1]))
                {
                    $routeAndParams['villagerSlug'] = $tab[1];
                }
            }
            else if($tab[0] === "my-games") // If route begins by my-games
            {
                $routeAndParams['route'] = "my-games"; // I save the value in the array
                if(isset($tab[1]))
                {
                    $routeAndParams['fileSlug'] = $tab[1];
                }
            }
        }
        else
        {
            $routeAndParams['route'] = "";
        }

        return $routeAndParams;
    }

    // Create a method to check the routes
    public function checkRoute(string $route) : void
    {
        $routeTab = $this->splitRouteAndParameters($route);

        if(isset($_GET['route']))
        {
            $fileId = $_SESSION['file_id'];
            $fileName = $_SESSION['file_slug'];

            if($routeTab['route'] === "")
            {
                $this->spc->render("staticpages/homepage.phtml", []);
                $this->fc->uploadFile();
                $this->pbc->readSavedFile($fileId);
            }
            else if($routeTab['route'] === "login")
            {
                $this->uc->loadUser();
            }
            else if($routeTab['route'] === "register")
            {
                $this->uc->createUser();
            }
            else if($routeTab['route'] === "my-account" && isset($_SESSION['user']))
            {
                $this->uc->account($_SESSION['user_id']);
            }
            else if($routeTab['route'] === "my-account/edit" && isset($_SESSION['user']))
            {
                $this->uc->editUser();
            }
            else if($routeTab['route'] === "my-account/delete" && isset($_SESSION['user']))
            {
                $this->uc->deleteUser();
            }
            else if($routeTab['route'] === "my-games" && isset($_SESSION['user']) && $routeTab['fileSlug'] === null)
            {
                $this->fc->indexGames();
            }
            else if($routeTab['route'] === "my-games/$fileName" && isset($_SESSION['user']) && !empty($routeTab['fileSlug']))
            {
                $this->fc->getFileById($fileId);
                $this->pbc->displayProgress($fileId);
            }
            else if($routeTab['route'] === "logout")
            {
                $this->uc->logoutUser();
            }
            else if($routeTab['route'] === "villagers")
            {
                $this->npc->index();
            }
            else if($routeTab['route'] === "villagers/$name" && isset($_SESSION['user']) && !empty($routeTab['villagerSlug']))
            {
                $_SESSION['villager_id'] = $villager_id;
                $this->npc->getVillagerById($villager_id);
                $this->npc->displayVillagerData($villager_id);
            }
            else if($routeTab['route'] === "confidentiality")
            {
                $this->spc->render("staticpages/confidentiality.phtml", []);
            }
            else if($routeTab['route'] === "legal-notices")
            {
                $this->spc->render("staticpages/legal-notices.phtml", []);
            }
            else if($routeTab['route'] === "credits")
            {
                $this->spc->render("staticpages/credits.phtml", []);
            }
            else if($routeTab['route'] === "admin" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->ac->index();
                $this->mc->addPicture();
                // $this->npc->addVillagers(); I only need it once to add all the villagers to the database
                // $this->npc->addVillagerPlanning(); I only need it once to add the schedule of each villager
                // $this->ic->addItems(); I only need it once to add the items to the database
            }
            else if($_GET['route'] === "admin/all-users" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->ac->getAllUsers();
            }
            else if($_GET['route'] === "admin/all-saved-games" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->ac->getAllGames();
            }
            else if($_GET['route'] === "admin/delete" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->uc->deleteUser();
                //Delete the user without rendering the delete form for the front part
            }
            else if($_GET['route'] === "admin/statistics" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->ac->displayStatistics();
            }
            else if($_GET['route'] === "admin/edit" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                $this->ac->edit();
            }
        }
        // else
        // {
        //     $this->spc->render("staticpages/homepage.phtml", []);
        // }
    }
}

?>