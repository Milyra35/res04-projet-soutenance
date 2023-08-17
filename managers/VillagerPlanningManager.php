<?php

class VillagerPlanningManager extends AbstractManager {
    private PictureManager $pm;
    private VillagerManager $vm;

    public function __construct()
    {
        parent::__construct();
        $this->pm = new PictureManager();
        $this->vm = new VillagerManager();
    }

    // Add a planning to the database
    public function addPlanning(VillagerPlanning $planning) : VillagerPlanning
    {
        $query=$this->db->prepare("INSERT INTO villagers_planning (villager_id, schedule)
                                VALUES (:villager_id, :schedule)");
        $parameters=[
            'villager_id' => $planning->getVillager()->getId(),
            'schedule' => json_encode($planning->getSchedule())
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $planning->setId($this->db->lastInsertId());

        return $planning;
    }

    // Get the planning by its ID
    public function getPlanningById(int $id) : VillagerPlanning
    {
        $query=$this->db->prepare("SELECT * FROM villagers_planning WHERE id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $planning = new VillagerPlanning($this->vm->getVillagerById($data['villager_id']), json_decode($data['schedule'], true));
        $planning->setId($data['id']);

        return $planning;
    }
}

?>