<?php

class CommunityCenter {
    private ?int $id;
    private SavedFile $file;
    private string $bundleName;
    private array $items;

    public function __construct(SavedFile $file, string $bundleName, array $items)
    {
        $this->id = null;
        $this->file = $file;
        $this->bundleName = $bundleName;
        $this->items = [];
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

	public function getBundleName() : string
	{
		return $this->bundleName;
	}
	public function setBundleName(string $bundleName) : void
	{
		$this->bundleName = $bundleName;
	}

	public function getItems() : array
	{
		return $this->items;
	}
	public function setItems(array $items) : void
	{
		$this->items = $items;
	}
}

?>