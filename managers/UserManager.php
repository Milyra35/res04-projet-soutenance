<?php

class UserManager extends AbstractManager {
    // Get all users
    public function getAllUsers() : array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach($data as $user)
        {
            $newUser = new User($user['username'], $user['password'], $user['email']);
            $newUser->setId($user['id']);
            $newUser->setRole($user['role_id']);
            $users[] = $newUser;
        }

        return $users;
    }

    // Get an user by its ID
    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User($data['username'], $data['password'], $data['email']);

        $user->setId($data['id']);
        $user->setRole($data['role_id']);
        //$user->setRegistrationDate($data['registration_date']);

        return $user;
    }

    // Get an user by its username
    public function getUserByUsername(string $username) : User
    {
        $query=$this->db->prepare("SELECT * FROM users WHERE users.username = :username");
        $parameters=['username' => $username];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        $user = new User($data['username'], $data['password'], $data['email']);

        $user->setId($data['id']);
        $user->setRole($data['role_id']);
        $user->setRegistrationDate($data['registration_date']);

        return $user;
    }
}

?>