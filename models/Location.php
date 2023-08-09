<?php

class Location {
    private ?int $id;
    private SavedFile $file;
    private string $name;
    private bool $isDiscovered;

    public function __construct(SavedFile $file, string $name, bool $isDiscovered)
    {
        $this->id = null;
        $this->file = $file;
        $this->name = $name;
        $this->isDiscovered = $isDiscovered;
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

	public function getIsDiscovered() : bool
	{
		return $this->isDiscovered;
	}
	public function setIsDiscovered(bool $isDiscovered) : void
	{
		$this->isDiscovered = $isDiscovered;
	}
}

?>