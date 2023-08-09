<?php

class PlayerSkill {
    private ?int $id;
    private SavedFile $file;
    private string $name;
    private int $level;

    public function __construct(SavedFile $file, string $name, int $level)
    {
        $this->id = null;
        $this->file = $file;
        $this->name = $name;
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

	public function getName() : string
	{
		return $this->name;
	}

	public function setName(string $name) : void
	{
		$this->name = $name;
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