<?php

class User {
    private ?int $id;
    private string $username;
    private string $password;
    private string $email;
    private ?string $registration_date;
    private Role $role;

    public function __construct(string $username, string $password, string $email, Role $role)
    {
        $this->id = null;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->registration_date = null;
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

    public function getRegistrationDate() : ?string
    {
        return $this->registration_date;
    }
    public function setRegistrationDate(?string $registration_date) : void
    {
        $this->registration_date = $registration_date;
    }

    public function getRole() : Role
    {
        return $this->role;
    }
    public function setRole(Role $role) : void
    {
        $this->role = $role;
    }
}

?>