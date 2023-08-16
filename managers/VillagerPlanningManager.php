<?php

class VillagerPlanningManager extends AbstractManager {
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
        $planning = new VillagerPlanning($this->getVillagerById($data['villager_id']), $data['schedule']);
        $planning->setId($data['id']);

        return $planning;
    }
}

?>