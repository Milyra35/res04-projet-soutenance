<?php

class UserController extends AbstractController {
    private UserManager $um;

    public function __construct()
    {
        $this->um = new UserManager();
    }

    public function getAllUsers()
    {
        $users=$this->manager->getAllUsers();
        $this->render("admin/users/users.phtml", $users);
    }

    public function createUser()
    {
        if(isset($_POST['submit-new-user']))
        {
            $existingUser = $this->um->verifyUsername(htmlspecialchars($_POST['username']));

            // Checking if the username doesn't already exist
            if(!$existingUser)
            {
                if(!empty($_POST['username']))
                {
                    $username = htmlspecialchars($_POST['username']);
                }
                if(!empty($_POST['email']))
                {
                    $email = htmlspecialchars($_POST['email']);
                }
                if(!empty($_POST['password']) && $_POST['password'] === $_POST['confirm-password'])
                {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
                else
                {
                    $this->render("user/create.phtml", ['message' => "Both passwords aren't the same"]);
                }

                // We have to set a registration date for the database
                date_default_timezone_set("Europe/Paris");
                $registrationDate = date("Y-m-d H:i:s");

                // We add the role defined for the users
                $userRole = new Role(2, "user");

                // Then we create the user
                $user = new User($username, $password, $email, $userRole);
                $user->setRegistrationDate($registrationDate);

                // We add it to the database
                $this->um->createUser($user);

                header("Location:/res04-projet-soutenance/login");
            }
            else
            {
                $error = $this->toJson(['message' => "This username already exists"]);
                // If it already exists, return on the register form
                // $this->render("user/create.phtml", $error);
            }
        }
        else
        {
            $this->render("user/create.phtml", []);
        }
    }

    // Load a user to create a session user
    public function login()
    {
        if(isset($_POST['login']))
        {
            $existingUser = $this->um->verifyUsername(htmlspecialchars($_POST['username']));

            // I check if the username is valid in the database
            if($existingUser)
            {
                if(!empty($_POST['username']))
                {
                    $username = htmlspecialchars($_POST['username']);
                }
                if(!empty($_POST['password']))
                {
                    $password = $_POST['password'];
                }

                $user = $this->um->getUserByUsername($username);

                // If a user logins 
                if(isset($user) && $user->getRole()->getName() === "user" && password_verify($password, $user->getPassword()))
                {
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['user'] = $user;
                    $_SESSION['role'] = $user->getRole()->getName();

                    header("Location:/res04-projet-soutenance/my-games");
                }
                // If an admin logins
                else if(isset($user) && $user->getRole()->getName() === "admin" && password_verify($password, $user->getPassword()))
                {
                    $_SESSION['admin_id'] = $user->getId();
                    $_SESSION['admin'] = $user;
                    $_SESSION['role'] = $user->getRole()->getName();
                    
                    header("Location:/res04-projet-soutenance/admin");
                }
                else
                {
                    $this->render("user/login.phtml", ['message' => "Invalid username"]);
                }
            }
            else
            {
                $this->render("user/login.phtml", ['message' => "Invalid username or password"]);
            }
        }
        else
        {
            $this->render("user/login.phtml", []);
        }
    }

    // To edit a user
    public function editUser()
    {
        if(isset($_POST['submit-edit-user']))
        {
            $existingUser = $this->um->verifyUsername(htmlspecialchars($_POST['new-user-username']));

            // Checking if the username already exists
            if(!$existingUser)
            {
                // We get the new informations
                if(!empty($_POST['new-user-username']))
                {
                    $newUsername = htmlspecialchars($_POST['new-user-username']);
                }
                if(!empty($_POST['new-user-email']))
                {
                    $newEmail = htmlspecialchars($_POST['new-user-email']);
                }
                if(!empty($_POST['new-user-password']) && $_POST['new-user-password'] === $_POST['confirm-new-user-password'])
                {
                    $newPassword = password_hash($_POST['new-user-password'], PASSWORD_DEFAULT);
                }

                $role = new Role(2, "user");
                $user = new User($newUsername, $newPassword, $newEmail, $role);
                $user->setId($_SESSION['user_id']);
                $this->um->editUser($user);

                header("Location:/res04-projet-soutenance/my-account");
            }
            else 
            {
                $this->render("user/edit.phtml", ['message' => 'This username already exists']);
            }
        }
        else
        {
            $this->render("user/edit.phtml", []);
        }
    }

    public function logoutUser()
    {
        if(isset($_POST['logout']))
        {
            session_destroy();
            header("Location:/res04-projet-soutenance/");
        }
    }

    // Add a method to render the informations of the account
    public function account(int $id)
    {
        $user = $this->um->getUserById($id);
        $this->render("user/my-account.phtml", ["user" => $user]);
    }
}

?>