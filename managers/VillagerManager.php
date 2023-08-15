<?php

class VillagerManager extends AbstractManager {
    // Get a picture by its ID
    public function getPictureById(int $id) : Picture
    {
        $query=$this->db->prepare("SELECT * FROM pictures WHERE pictures.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $picture = new Picture($data['name'], $data['url']);
        $picture->setId($data['id']);

        return $picture;
    }

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
        
        try 
        {
            $query->execute($parameters);
            // Set the ID of the inserted row
            $npc->setId($this->db->lastInsertId());
    
            return $npc;
        } 
        catch (PDOException $e) {
            // Handle the exception, print or log the error message
            echo "Error adding villager: " . $e->getMessage();
            return null;
        }
    }

    // Get a villager by its ID
    public function getVillagerById(int $id) : Villager
    {
        $query=$this->db->prepare("SELECT * FROM villagers WHERE villagers.id = :id");
        $parameters=['id'=> $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $villager = new Villager(
            $data['name'],
            $data['love'],
            $data['like'],
            $data['neutral'],
            $data['dont_like'],
            $data['hate'],
            $data['is_datable'],
            $data['birthday'],
            $data['events'],
            $this->getPictureById($data['picture_id'])
        );
        $villager->setId($data['id']);

        return $villager;
    }
}

?>