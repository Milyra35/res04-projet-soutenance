<?php

class AdminController extends AbstractController {
    private UserManager $um;
    private FileManager $fm;
    private StatisticManager $sm;

    public function __construct()
    {
        $this->um = new UserManager();
        $this->fm = new FileManager();
        $this->sm = new StatisticManager();
    }

    public function index()
    {
        $this->render("dashboard/dashboard.phtml", [], "admin");
    }

    // To display all the files uploaded by the users
    public function getAllGames()
    {
        $files = $this->fm->getAllGames();
        $this->render('users/games.phtml', $files, "admin");
    }

    // To display all the users
    public function getAllUsers()
    {
        $users = $this->um->getAllUsers();
        $this->render('users/users.phtml', $users, "admin");
    }

    // To display all statistics
    public function displayStatistics()
    {
        $stats = $this->sm->getAllStats();
        $this->render('users/statistics.phtml', $stats, "admin");
    }
}

?>