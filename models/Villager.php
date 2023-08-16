<?php

class Villager {
    private ?int $id;
    private string $name;
    private array $love;
    private array $like;
    private array $neutral;
    private array $dislike;
    private array $hate;
    private bool $isDatable;
    private string $birthday;
    private array $events;
    private Picture $picture;

    public function __construct(string $name, array $love, array $like, array $neutral, array $dislike, array $hate, bool $isDatable, string $birthday, array $events, Picture $picture)
    {
        $this->id = null;
        $this->name = $name;
        $this->love = $love;
        $this->like = $like;
        $this->neutral = $neutral;
        $this->dislike = $dislike;
        $this->hate = $hate;
        $this->isDatable = $isDatable;
        $this->birthday = $birthday;
        $this->events = $events;
        $this->picture = $picture;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getName() : string
    {
        return $this->name;
    }
    public function setName($name) : void
    {
        $this->name = $name;
    }

    public function getLove() : array
    {
        return $this->love;
    }
    public function setLove(array $love) : void
    {
        $this->love = $love;
    }

    public function getLike() : array
    {
        return $this->like;
    }
    public function setLike(array $like) : void
    {
        $this->like = $like;
    }

    public function getNeutral() : array
    {
        return $this->neutral;
    }
    public function setNeutral(array $neutral) : void
    {
        $this->neutral = $neutral;
    }
 
    public function getDislike() : array
    {
        return $this->dislike;
    }
    public function setDislike(array $dislike) : void
    {
        $this->dislike = $dislike;
    }

    public function getHate() : array
    {
        return $this->hate;
    }
    public function setHate(array $hate) : void
    {
        $this->hate = $hate;
    }

    public function getIsDatable() : bool
    {
        return $this->isDatable;
    }
    public function setIsDatable(bool $isDatable) : void
    {
        $this->isDatable = $isDatable;
    }

    public function getBirthday() : string
    {
        return $this->birthday;
    }
    public function setBirthday(string $birthday) : void
    {
        $this->birthday = $birthday;
    }

    public function getEvents() : array
    {
        return $this->events;
    }
    public function setEvents(array $events) : void
    {
        $this->events = $events;
    }

    public function getPicture() : Picture
    {
        return $this->picture;
    }
    public function setPicture(Picture $picture) : void
    {
        $this->picture = $picture;
    }
}

?>