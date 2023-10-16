<?php

class Statistic {
    private ?int $id;
    private SavedFile $file;
    private int $hoursPlayed;
    private int $daysSpent;
    private int $seasonsPassed;
    private int $fishCatched;
	private int $monstersKilled;
	private int $moneyEarned;

    public function __construct(SavedFile $file, int $hoursPlayed, int $daysSpent, int $seasonsPassed, int $fishCatched, int $monstersKilled, int $moneyEarned)
    {
        $this->id = null;
        $this->file = $file;
        $this->hoursPlayed = $hoursPlayed;
        $this->daysSpent = $daysSpent;
        $this->seasonsPassed = $seasonsPassed;
        $this->fishCatched = $fishCatched;
		$this->monstersKilled = $monstersKilled;
		$this->moneyEarned = $moneyEarned;
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

	public function getHoursPlayed() : int
	{
		return $this->hoursPlayed;
	}
	public function setHoursPlayed(int $hoursPlayed) : void
	{
		$this->hoursPlayed = $hoursPlayed;
	}

	public function getDaysSpent() : int
	{
		return $this->daysSpent;
	}
	public function setDaysSpent(int $daysSpent) : void
	{
		$this->daysSpent = $daysSpent;
	}

	public function getSeasonsPassed() : int
	{
		return $this->seasonsPassed;
	}
	public function setSeasonsPassed(int $seasonsPassed) : void
	{
		$this->seasonsPassed = $seasonsPassed;
	}

	public function getFishCatched() : int
	{
		return $this->fishCatched;
	}
	public function setFishCatched(int $fishCatched) : void
	{
		$this->fishCatched = $fishCatched;
	}

	public function getMonstersKilled() : int
	{
		return $this->monstersKilled;
	}
	public function setMonstersKilled(int $monstersKilled) : void
	{
		$this->monstersKilled = $monstersKilled;
	}

	public function getMoneyEarned() : int
	{
		return $this->moneyEarned;
	}
	public function setMoneyEarned(int $moneyEarned) : void
	{
		$this->moneyEarned = $moneyEarned;
	}
}

?>