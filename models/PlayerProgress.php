<?php

class PlayerProgress {
    private ?int $id;
    private SavedFile $file;
    private string $playerName;
    // private int $experienceLevel;
    private int $money;
    private int $health;
    private int $energy;
    private bool $cat;
    private bool $dog;
    private string $petName;
    private bool $isMarried;
    private bool $hasChildren;
	private ?string $spouse;

    public function __construct(SavedFile $file, string $playerName, int $money,int $health, int $energy, bool $cat, bool $dog, string $petName, bool $isMarried, bool $hasChildren)
    {
        $this->id = null;
        $this->file = $file;
        $this->playerName = $playerName;
        // $this->experienceLevel = $experienceLevel;
        $this->money = $money;
        $this->health = $health;
        $this->energy = $energy;
        $this->cat = $cat;
        $this->dog = $dog;
        $this->petName = $petName;
        $this->isMarried = $isMarried;
        $this->hasChildren = $hasChildren;
		$this->spouse = null;
    }

	public function getId() : ?int
	{
		return $this->id;
	}

	public function setId($id) : void
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

	public function getPlayerName() : string
	{
		return $this->playerName;
	}

	public function setPlayerName(string $playerName) : void
	{
		$this->playerName = $playerName;
	}

	// public function getExperienceLevel() : int
	// {
	// 	return $this->experienceLevel;
	// }

	// public function setExperienceLevel(int $experienceLevel) : void
	// {
	// 	$this->experienceLevel = $experienceLevel;
	// }

	public function getMoney() : int
	{
		return $this->money;
	}

	public function setMoney(int $money) : void
	{
		$this->money = $money;
	}

	public function getHealth() : int
	{
		return $this->health;
	}

	public function setHealth(int $health) : void
	{
		$this->health = $health;
	}

	public function getEnergy() : int
	{
		return $this->energy;
	}

	public function setEnergy(int $energy) : void
	{
		$this->energy = $energy;
	}

	public function getCat() : bool
	{
		return $this->cat;
	}

	public function setCat(bool $cat) : void
	{
		$this->cat = $cat;
	}

	public function getDog() : bool
	{
		return $this->dog;
	}

	public function setDog(bool $dog) : void
	{
		$this->dog = $dog;
	}

	public function getPetName() : string
	{
		return $this->petName;
	}
	public function setPetName(string $petName) : void
	{
		$this->petName = $petName;
	}

	public function getIsMarried() : bool
	{
		return $this->isMarried;
	}
	public function setIsMarried(bool $isMarried) : void
	{
		$this->isMarried = $isMarried;
	}

	public function getHasChildren() : bool
	{
		return $this->hasChildren;
	}
	public function setHasChildren(bool $hasChildren) : void
	{
		$this->hasChildren = $hasChildren;
	}

	public function getSpouse() : ?string
	{
		return $this->spouse;
	}
	public function setSpouse(string $spouse) : void
	{
		$this->spouse = $spouse;
	}
}

?>