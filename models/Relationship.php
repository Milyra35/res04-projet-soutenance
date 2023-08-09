<?php

class Relationship {
    private ?int $id;
    private SavedFile $file;
    private Villager $villager;
    private int $level;

    public function __construct(SavedFile $file, Villager $villager, int $level)
    {
        $this->id = null;
        $this->file = $file;
        $this->villager = $villager;
        $this->level = $level;
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

	public function getVillager() : Villager
	{
		return $this->villager;
	}
	public function setVillager(Villager $villager) : void
	{
		$this->villager = $villager;
	}

	public function getLevel() : int
	{
		return $this->level;
	}
	public function setLevel(int $level) : void
	{
		$this->level = $level;
	}
}

?>