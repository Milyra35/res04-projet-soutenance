<?php

class Book {
    private ?int $id;
    private SavedFile $file;
    private string $name;
    private bool $has;

    public function __construct(SavedFile $file, string $name, bool $has)
    {
        $this->id = null;
        $this->file = $file;
        $this->name = $name;
        $this->has = $has;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getFile() : SavedFile
    {
        return $this->file;
    }
    public function setFile(SavedFile $file) : void
    {
        $this->file = $file;
    }

    public function getName() : string
    {
        return $this->name;
    }
    public function setName($name) : void
    {
        $this->name = $name;
    }

    public function getHas() : bool
    {
        return $this->has;
    }
    public function setHas(bool $has) : void
    {
        $this->has = $has;
    }
}

?>