<?php

class Book {
    private ?int $id;
    private SavedFile $file;
    private int $amount;

    public function __construct(SavedFile $file, int $amount)
    {
        $this->id = null;
        $this->file = $file;
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