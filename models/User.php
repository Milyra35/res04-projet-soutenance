<?php

class User {
    private ?int $id;
    private string $username;
    private string $password;
    private string $email;
    private DateTime $registration_date;
    private Role $role;

    public function __construct(string $username, string $password, string $email, Date $registration_date, Role $role)
    {
        $this->id = null;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->registration_date = new DateTime();
        $this->role = $role;
    }


    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getUsername() : string
    {
        return $this->username;
    }
    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }
 
    public function getEmail() : string
    {
        return $this->email;
    }
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getRegistrationDate() : DateTime
    {
        return $this->registration_date;
    }
    public function setRegistrationDate(DateTime $registration_date) : void
    {
        $this->registration_date = $registration_date;
    }

    public function getRole() : int
    {
        return $this->role;
    }
    public function setRole(int $role) : void
    {
        $this->role = $role;
    }
}

?>