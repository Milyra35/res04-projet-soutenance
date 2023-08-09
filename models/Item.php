<?php

class Item {
    private ?int $id;
    private Picture $picture;
    private string $type;
    private string $name;
    private string $description;

    public function __construct(Picture $picture, string $type, string $name, string $description)
    {
        $this->id = null;
        $this->picture = $picture;
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getPicture() : Picture
    {
        return $this->picture;
    }
    public function setPicture(Picture $picture) : void
    {
        $this->picture = $picture;
    }

    public function getType() : string
    {
        return $this->type;
    }
    public function setType(string $type) : void
    {
        $this->type = $type;
    }

    public function getName() : string
    {
        return $this->name;
    }
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }
}

?>