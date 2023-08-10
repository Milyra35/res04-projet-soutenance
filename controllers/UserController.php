<?php

class UserController extends AbstractController {
    private UserManager $um;

    public function __construct()
    {
        $this->um = new UserManager();
    }

    public function createUser()
    {
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
            $registrationDate = date("Y-m-d");

            // We create the role defined for the users
            $userRole = new Role("user");
            
            // Then we create the user
            $user = new User($username, $password, $email, $registrationDate, $userRole);

            // We add it to the database
            $this->um->createUser($user);

            header("Location:index.php?route=login");
        }
    }
}

?>