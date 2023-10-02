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

    public function index(int $id)
    {
        $admin = $this->um->getUserById($id);
        // $datas = $this->fm->getAllDatas();
        $this->render("dashboard/dashboard.phtml", ["admin" => $admin], "admin");
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

        $total = [];
        $totalHours = 0;
        $totalDays = 0;
        $totalSeasons = 0;
        $totalFishes = 0;

        foreach($stats as $stat)
        {
            $totalHours += $stat->getHoursPlayed();
            $totalDays += $stat->getDaysSpent();
            $totalSeasons += $stat->getSeasonsPassed();
            $totalFishes += $stat->getFishCatched();
        }

        $averageHours = intval($totalHours / count($stats));
        $averageDays = intval($totalDays / count($stats));
        $averageSeasons = intval($totalSeasons / count($stats));
        $averageFishes = intval($totalFishes / count($stats));

        $total[] = $averageHours;
        $total[] = $averageDays;
        $total[] = $averageSeasons;
        $total[] = $averageFishes;
        // var_dump($total);
        
        $this->render('users/statistics.phtml', ['stats' => $stats, 'total' => $total], "admin");
    }

    // To delete a User in the list of all users
    public function deleteUserFromAdmin()
    {
        if(isset($_POST['submit-delete-account-admin']))
        {
            $this->um->deleteUser($_POST['user_id']);
        }
    }

    // To change the role of an admin
    public function changeRoleOfUser()
    {
        if(isset($_POST['submit-change-role']))
        {
            $this->um->editRole($_POST['user_to_edit_id'], $_POST['user_role_id']);
            // echo json_encode(['message' => 'Success']);

            header('Location:/res04-projet-soutenance/admin/all-users');
        }
    }

    public function editAdmin()
    {
        if(isset($_POST['submit-edit-admin']))
        {
            $existingUser = $this->um->verifyUsername(htmlspecialchars($_POST['new-username']));

            // Checking if the username already exists
            if(!$existingUser)
            {
                if(!empty($_POST['new-username']) && !empty($_POST['new-email']) &&
                    !empty($_POST['new-password']) && $_POST['new-password'] === $_POST['confirm-new-password'])
                {
                    $newUsername = htmlspecialchars($_POST['new-username']);
                    $newEmail = htmlspecialchars($_POST['new-email']);
                    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                }

                $role = new Role(1, "admin");
                $admin = new User($newUsername, $newPassword, $newEmail, $role);
                $admin->setId($_SESSION['admin_id']);
                $this->um->editUser($admin);

                header("Location:/res04-projet-soutenance/admin");
            }
        }
        else
        {
            $this->render("admin/edit.phtml", [], "admin");
        }
    }
}

?>