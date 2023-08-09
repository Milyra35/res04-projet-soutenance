<?php

class PossessedItem {
    private ?int $id;
    private SavedFile $file;
    private string $name;
    private int $amount;

    public function __construct(SavedFile $file, stirng $name, int $amount)
    {
        $this->id = null;
        $this->file = $file;
        $this->name = $name;
        $this->amount = $amount;
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

	public function getAmount() : int
	{
		return $this->amount;
	}

	public function setAmount(int $amount) : void
	{
		$this->amount = $amount;
	}
}

?>