<?php

class VillagerPlanning {
    private ?int $id;
    private Villager $villager;
    private array $schedule;

    public function __construct(Villager $villager, array $schedule)
    {
        $this->id = null;
        $this->villager = $villager;
        $this->schedule = $schedule;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getVillager() : Villager
    {
        return $this->villager;
    }
    public function setVillager(Villager $villager) : void
    {
        $this->villager = $villager;
    }
 
    public function getSchedule() : array
    {
        return $this->schedule;
    }
    public function setSchedule(array $schedule) : void
    {
        $this->schedule = $schedule;
    }
}

?>