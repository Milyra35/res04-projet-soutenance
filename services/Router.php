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
        $routeAndParams['user'] = null;
        $routeAndParams['admin'] = null;


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
            else if($tab[0] === "my-account")
            {
                $routeAndParams['route'] = "my-account";
                if(isset($tab[1]) && $tab[1] === "edit")
                {
                    $routeAndParams['user'] = $tab[1];
                }
                else if(isset($tab[1]) && $tab[1] === "delete")
                {
                    $routeAndParams['user'] = $tab[1];
                }
            }
            else if($tab[0] === "admin")
            {
                $routeAndParams['route'] = "admin";
                if(isset($tab[1]) && $tab[1] === "all-users")
                {
                    $routeAndParams['admin'] = $tab[1];
                }
                else if(isset($tab[1]) && $tab[1] === "all-saved-games")
                {
                    $routeAndParams['admin'] = $tab[1];
                }
                else if(isset($tab[1]) && $tab[1] === "statistics")
                {
                    $routeAndParams['admin'] = $tab[1];
                }
                else if(isset($tab[1]) && $tab[1] === "edit")
                {
                    $routeAndParams['admin'] = $tab[1];
                }
            }
            else if($tab[0] === "login")
            {
                $routeAndParams['route'] = "login";
            }
            else if($tab[0] === "register")
            {
                $routeAndParams['route'] = "register";
            }
            else if($tab[0] === "logout")
            {
                $routeAndParams['route'] = "logout";
            }
            else if($tab[0] === "confidentiality")
            {
                $routeAndParams['route'] = "confidentiality";
            }
            else if($tab[0] === "legal-notices")
            {
                $routeAndParams['route'] = "legal-notices";
            }
            else if($tab[0] === "credits")
            {
                $routeAndParams['route'] = "credits";
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
        
        if($routeTab['route'] === "")
        {
            $this->spc->render("staticpages/homepage.phtml", []);
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
        else if($routeTab['route'] === "my-account" && $routeTab['user'] === "edit" && isset($_SESSION['user']))
        {
            $this->uc->editUser();
        }
        else if($routeTab['route'] === "my-account" && $routeTab['user'] === "delete" && isset($_SESSION['user']))
        {
            $this->uc->deleteUser();
        }
        else if($routeTab['route'] === "my-games" && isset($_SESSION['user']) && $routeTab['fileSlug'] === null)
        {
            $this->fc->indexGames();
            $this->fc->uploadFile();
        }
        else if($routeTab['route'] === "my-games" && $routeTab['fileSlug'] !== null && isset($_SESSION['user']))
        {
            // $this->fc->getFileById(intval($routeTab['fileSlug']));
            $this->fc->readSavedFile(intval($routeTab['fileSlug']));
            $this->pbc->displayProgress(intval($routeTab['fileSlug']));
        }
        else if($routeTab['route'] === "logout")
        {
            $this->uc->logoutUser();
        }
        else if($routeTab['route'] === "villagers" && $routeTab['villagerSlug'] === null)
        {
            $this->npc->index();
        }
        else if($routeTab['route'] === "villagers" && $routeTab['villagerSlug'] !== null)
        {
            // $this->npc->getVillagerById(intval($routeTab['villagerSlug']));
            $this->npc->displayVillagerData(intval($routeTab['villagerSlug']));
        }
        else if($routeTab['route'] === "confidentiality")
        {
            $this->spc->render("staticpages/confidentiality.phtml", []); // Change to put a method called index instead
        }
        else if($routeTab['route'] === "legal-notices")
        {
            $this->spc->render("staticpages/legal-notices.phtml", []); // Change to put a method called index instead
        }
        else if($routeTab['route'] === "credits")
        {
            $this->spc->render("staticpages/credits.phtml", []); // Change to put a method called index instead
        }
        else if($routeTab['route'] === "admin" && isset($_SESSION['role']) && $_SESSION['role'] === "admin")
        {
            $this->ac->index();
            $this->mc->addPicture();
            // $this->npc->addVillagers(); I only need it once to add all the villagers to the database
            // $this->npc->addVillagerPlanning(); I only need it once to add the schedule of each villager
            // $this->ic->addItems(); I only need it once to add the items to the database

            if($routeTab['admin'] === "all-users")
            {
                $this->ac->getAllUsers();
            }
            else if($routeTab['admin'] === "all-saved-games")
            {
                $this->ac->getAllGames();
            }
            else if($routeTab['admin'] === "delete")
            {
                $this->uc->deleteUser();
                //Delete the user without rendering the delete form for the front part
            }
            else if($routeTab['admin'] === "statistics")
            {
                $this->ac->displayStatistics();
            }
            else if($routeTab['admin'] === "edit")
            {
                $this->ac->edit();
            }
        }
        
    }
}

?>