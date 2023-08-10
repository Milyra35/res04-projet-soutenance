<?php

class VillagerManager extends AbstractManager {
    // Get all the villagers
    public function getAllVillagers() : array
    {
        $query=$this->db->prepare("SELECT * FROM villagers");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $villagers = [];

        foreach($data as $villager)
        {
            $newNPC = new Villager(
                $villager['name'], 
                $villager['love'], 
                $villager['like'], 
                $villager['neutral'], 
                $villager['dont_like'], 
                $villager['hate'], 
                $villager['is_datable'], 
                $villager['birthday'], 
                $villager['events'], 
                $this->getPictureById($villager['picture_id'])
            );
            $newNPC->setId($villager['id']);
            $villagers[] = $newNPC;
        }

        return $villagers;
    }

    // Add a villager to the database
    public function addVillager(Villager $npc) : Villager
    {
        $query=$this->db->prepare("INSERT INTO villagers (name, love, like, neutral, dont_like, hate, is_datable, birthday, events, picture_id) 
                                    VALUES (:name, :love, :like, :neutral, :dont_like, :hate, :is_datable, :birthday, :events, :picture_id)");
        $parameters=[
            'name'=> $npc->getName(),
            'love'=> $npc->getLove(),
            'like'=> $npc->getLike(),
            'neutral'=> $npc->getNeutral(),
            'dont_like'=> $npc->getDislike(),
            'hate'=> $npc->getHate(),
            'is_datable'=> $npc->getIsDatable(),
            'birthday'=> $npc->getBirthday(),
            'events'=> $npc->getEvents(),
            'picture_id'=> $npc->getPicture()->getId()
        ];
        $query->execute($parameters);

        $data=$query6>fetch(PDO::FETCH_ASSOC);
        $npc->setId($this->db->lastInsertId());

        return $npc;
    }
}

?>