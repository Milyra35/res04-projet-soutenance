<?php

class CommunityCenter {
    private ?int $id;
    private SavedFile $file;
    private string $bundleName;
    private bool $complete;

    public function __construct(SavedFile $file, string $bundleName, bool $complete)
    {
        $this->id = null;
        $this->file = $file;
        $this->bundleName = $bundleName;
		$this->complete = $complete;
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

	public function getComplete() : bool
	{
		return $this->complete;
	}
	public function setComplete(bool $complete) : void
	{
		$this->complete = $complete;
	}
}

?>