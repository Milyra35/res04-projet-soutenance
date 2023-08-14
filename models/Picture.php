<?php

class Picture {
    private ?int $id;
    private string $name;
    private string $url;
    private string $alt;

    public function __construct(string $name, string $url, string $alt)
    {
        $this->id = null;
        $this->name = $name;
        $this->url = $url;
        $this->alt = $alt;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId($id) : void
    {
        $this->id = $id;
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

    public function getAlt() : string
    {
        return $this->alt;
    }
    public function setAlt(string $alt) : void
    {
        $this->alt = $alt;
    }
}

?>