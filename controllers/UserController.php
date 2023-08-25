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
            // $usernameExist = $this->um->getUserByUsername(htmlspecialchars($_POST['username']));
            // $emailExist = $this->um->getUserByEmail(htmlspecialchars($_POST['email']));

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
            $this->render("user/create.phtml", []);
        }
    }

    // Load a user to create a session user
    public function loadUser()
    {
        if(isset($_POST['login']))
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
            if($user->getRole()->getName() === "user" && password_verify($password, $user->getPassword()))
            {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $user->getRole()->getName();

                header("Location:/res04-projet-soutenance/my-games");
            }
            // If an admin logins
            else if($user->getRole()->getName() === "admin" && password_verify($password, $user->getPassword()))
            {
                $_SESSION['admin_id'] = $user->getId();
                $_SESSION['admin'] = $user;
                $_SESSION['role'] = $user->getRole()->getName();
                
                header("Location:/res04-projet-soutenance/admin");
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
            // We get the new informations
            if(!empty($_POST['new-username']))
            {
                $newUsername = htmlspecialchars($_POST['new-username']);
            }
            if(!empty($_POST['new-email']))
            {
                $newEmail = htmlspecialchars($_POST['new-email']);
            }
            if(!empty($_POST['new-password']) && $_POST['new-password'] === $_POST['confirm-new-password'])
            {
                $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
            }

            $role = new Role(2, "user");
            $user = new User($newUsername, $newPassword, $newEmail, $role);
            $user->setId($_SESSION['user_id']);
            $this->um->editUser($user);

            header("Location:/res04-projet-soutenance/my-account");
        }

        $this->render("user/edit.phtml", []);
    }

    public function deleteUser()
    {
        if(isset($_POST["submit-delete-account"]))
        {
            $this->um->deleteUser($_SESSION['user_id']);
            header("Location:/res04-projet-soutenance/");
        }
        else if(isset($_SESSION['role']) && $_SESSION['role'] === "admin" && isset($_POST["submit-delete-account-admin"]))
        {
            $this->um->deleteUser();
            // Add a delete button next to the user in all of the users
        }
        else
        {
            $this->render("user/delete.phtml", []);
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