<?php

class SavedFile {
    private ?int $id;
    private User $user;
    private string $name;
    private string $url;
    private ?string $date;

    public function __construct(User $user, string $name, string $url)
    {
        $this->id = null;
        $this->user = $user;
        $this->name = $name;
        $this->url = $url;
        $this->date = null;
    }
 
    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getUser() : User
    {
        return $this->user;
    }
    public function setUser(user $user) : void
    {
        $this->user = $user;
    }

    public function getName() : string
    {
        return $this->name;
    }
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getUrl() : string
    {
        return $this->url;
    }
    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

    public function getDate() : ?string
    {
        return $this->date;
    }
    public function setDate(?string $date) : void
    {
        $this->date = $date;
    }
}

?>