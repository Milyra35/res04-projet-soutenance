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

    // Get a role by its ID
    public function getRoleById(int $id) : Role
    {
        $query=$this->db->prepare("SELECT * FROM roles WHERE roles.id = :id");
        $parameters=['id'=> $id];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $role = new Role($id, $data["name"]);

        return $role;
    }

    // Get an user by its ID
    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User($data['username'], $data['password'], $data['email'], $this->getRoleById($data['role_id']));

        $user->setId($data['id']);
        $user->setRegistrationDate($data['registration_date']);

        return $user;
    }

    // Get an user by its username
    public function getUserByUsername(string $username) : User
    {
        $query=$this->db->prepare("SELECT * FROM users WHERE users.username = :username");
        $parameters=['username' => $username];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        $user = new User($data['username'], $data['password'], $data['email'], $this->getRoleById($data['role_id']));

        $user->setId($data['id']);
        $user->setRegistrationDate($data['registration_date']);

        return $user;
    }

    // Create a user
    public function createUser(User $user) : User
    {
        $query=$this->db->prepare("INSERT INTO users (username, password, email, registration_date, role_id)
                                    VALUES (:username, :password, :email, :registrationDate, :roleId)");
        $parameters= [
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'registrationDate' => $user->getRegistrationDate(),
            'roleId' => $user->getRole()->getId()
        ];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $user->setId($this->db->lastInsertId());

        return $user;
    }

    // Edit a user
    public function editUser(User $user) : void
    {
        $query=$this->db->prepare("UPDATE users SET username= :username, password= :password, email= :email");
        $parameters= [
            'username'=> $user->getUsername(),
            'password'=> $user->getPassword(),
            'email'=> $user->getEmail()
        ];
        $query->execute($parameters);
    }

    // Delete a user
    public function deleteUser(int $id) : void
    {
        $query=$this->db->prepare("DELETE FROM users WHERE users.id= :id");
        $parameters=['id'=> $id];
        $query->execute($parameters);
    }
}

?>