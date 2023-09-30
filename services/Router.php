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
        // var_dump($routeTab);
        
        if($routeTab['route'] === "")
        {
            $this->spc->renderHomepage();
        }
        else if($routeTab['route'] === "login")
        {
            $this->uc->login();
        }
        else if($routeTab['route'] === "register")
        {
            $this->uc->createUser();
        }
        else if($routeTab['route'] === "my-account")
        {
            if(isset($_SESSION['user']))
            {
                if($routeTab['user'] === null)
                {
                    $this->uc->account($_SESSION['user_id']);
                }
                else if($routeTab['route'] === "my-account" && $routeTab['user'] === "edit")
                {
                    $this->uc->editUser();
                }
                else if($routeTab['route'] === "my-account" && $routeTab['user'] === "delete")
                {
                    $this->fc->deleteUserAndData();
                }
            }
            else
            {
                $this->uc->login();
            }
        }
        else if($routeTab['route'] === "my-games")
        {
            if(isset($_SESSION['user']))
            {
                // if($routeTab['route'] === "upload-files")
                // {
                //     $this->fc->uploadFile();
                // }
                if($routeTab['fileSlug'] === null)
                {
                    $this->fc->indexGames();
                    $this->fc->uploadFile();
                }
                else if($routeTab['route'] === "my-games" && $routeTab['fileSlug'] !== null)
                {
                    $file = $this->fc->getFileById(intval($routeTab['fileSlug']));
                    $fileUser = $file->getUser()->getId();

                    if($fileUser === $_SESSION['user_id'])
                    {
                        $this->fc->readSavedFile(intval($routeTab['fileSlug']));
                        $this->pbc->displayProgress(intval($routeTab['fileSlug']));
                    }
                    else
                    {
                        header("Location:/res04-projet-soutenance/my-games");
                    }
                }
            }
            else
            {
                $this->uc->login();
            }
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
            $this->spc->renderConfidentiality();
        }
        else if($routeTab['route'] === "legal-notices")
        {
            $this->spc->renderLegalNotices();
        }
        else if($routeTab['route'] === "credits")
        {
            $this->spc->renderCredits();
        }
        else if($routeTab['route'] === "admin")
        {
            if(isset($_SESSION['role']) && $_SESSION['role'] === "admin")
            {
                if($routeTab['admin'] === null)
                {
                    $this->ac->index($_SESSION['admin_id']);
                    $this->mc->addPicture();
                    // $this->npc->addVillagers(); I only need it once to add all the villagers to the database
                    // $this->npc->addVillagerPlanning(); I only need it once to add the schedule of each villager
                    // $this->ic->addItems(); I only need it once to add the items to the database
                }
                else if($routeTab['admin'] === "all-users")
                {
                    $this->ac->getAllUsers();
                    $this->ac->deleteUserFromAdmin();
                    // $this->ac->changeRoleOfUser();
                }
                else if($routeTab['admin'] === "all-saved-games")
                {
                    $this->ac->getAllGames();
                }
                else if($routeTab['admin'] === "statistics")
                {
                    $this->ac->displayStatistics();
                }
                else if($routeTab['admin'] === "edit")
                {
                    $this->ac->editAdmin();
                }
                else if($routeTab['admin'] === "role-edit")
                {
                    $this->ac->changeRoleOfUser();
                }
            }
            else
            {
                $this->uc->login();
            }
        }
        else
        {
            $this->spc->render404();
        }
    }
}

?>