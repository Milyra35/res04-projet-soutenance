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
        $this->render("users/create.phtml", []);

        if(isset($_POST['submit-new-user']))
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

            header("Location:index.php?route=login");
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

            if($user->getRole()->getName() === "user" && password_verify($password, $user->getPassword()))
            {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user'] = $user;
                $_SESSION['role'] = $user->getRole()->getName();

                header("Location:index.php?route=my-games");
            }
            else if($user->getRole()->getName() === "admin" && password_verify($password, $user->getPassword()))
            {
                $_SESSION['admin_id'] = $user->getId();
                $_SESSION['admin'] = $user;
                $_SESSION['role'] = $user->getRole()->getName();
                
                header("Location:index.php?route=admin");
            }
            else
            {
                echo "Wrong informations";
                var_dump($_SESSION['role']);
            }
        }
        else
        {
            $this->render("users/login.phtml", []);
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
            if(!empty($_POST['new-password']))
            {
                $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
            }

            // We get the user logged in
            $user = $_SESSION['user'];
            $this->um->editUser($user);

            header("Location:index.php?route=my-account");
        }

        $this->render("users/edit.phtml", []);
    }

    public function deleteUser()
    {
        if(isset($_POST["submit-delete-account"]))
        {
            $this->um->deleteUser($_SESSION['user_id']);
            header("Location:index.php?route=homepage");
        }
    }

    public function logoutUser()
    {
        if(isset($_POST['logout']))
        {
            session_destroy();
            header("Location:index.php?route=homepage");
        }
    }
}

?>