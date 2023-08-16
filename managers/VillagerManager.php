<?php

class VillagerManager extends AbstractManager {
    // Get a picture by its ID
    public function getPictureById(int $id) : Picture
    {
        $query=$this->db->prepare("SELECT * FROM pictures WHERE pictures.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $picture = new Picture($data['name'], $data['url'], $data['alt']);
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
                json_decode($villager['love']),
                json_decode($villager['like']),
                json_decode($villager['neutral']),
                json_decode($villager['dont_like']),
                json_decode($villager['hate']),
                $villager['is_datable'],
                $villager['birthday'],
                json_decode($villager['events'], true),
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
        $query=$this->db->prepare("INSERT INTO villagers (name, love, `like`, neutral, dont_like, hate, is_datable, birthday, events, picture_id) 
                                    VALUES (:name, :love, :like, :neutral, :dont_like, :hate, :is_datable, :birthday, :events, :picture_id)");
        $parameters=[
            'name'=> $npc->getName(),
            'love'=> json_encode($npc->getLove()),
            'like'=> json_encode($npc->getLike()),
            'neutral'=> json_encode($npc->getNeutral()),
            'dont_like'=> json_encode($npc->getDislike()),
            'hate'=> json_encode($npc->getHate()),
            'is_datable'=> $npc->getIsDatable() ? 1 : 0,
            'birthday'=> $npc->getBirthday(),
            'events'=> json_encode($npc->getEvents()),
            'picture_id'=> $npc->getPicture()->getId()
        ];
        
        $query->execute($parameters);
        // Set the ID of the inserted row
        $npc->setId($this->db->lastInsertId());

        return $npc;
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
            json_decode($data['love']),
            json_decode($data['like']),
            json_decode($data['neutral']),
            json_decode($data['dont_like']),
            json_decode($data['hate']),
            $data['is_datable'],
            $data['birthday'],
            json_decode($data['events'], true),
            $this->getPictureById($data['picture_id'])
        );
        $villager->setId($data['id']);

        return $villager;
    }

    // Get a villager by its name
    public function getVillagerByName(string $name) : Villager
    {
        $query=$this->db->prepare("SELECT * FROM villagers WHERE villagers.name = :name");
        $parameters=['name' => $name];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $villager = new Villager(
            $data['name'],
            json_decode($data['love']),
            json_decode($data['like']),
            json_decode($data['neutral']),
            json_decode($data['dont_like']),
            json_decode($data['hate']),
            $data['is_datable'],
            $data['birthday'],
            json_decode($data['events'], true),
            $this->getPictureById($data['picture_id'])
        );
        $villager->setId($data['id']);

        return $villager;
    }
}

?>