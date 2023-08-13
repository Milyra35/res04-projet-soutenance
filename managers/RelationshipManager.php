<?php

class RelationshipManager extends AbstractManager {
    // Add a relationship in the database
    public function addRelationship(Relationship $relationship) : Relationship
    {
        $query=$this->db->prepare("INSERT INTO relationships (file_id, villager_id, friendship_level)
                                    VALUES (:file_id, :villager_id, :friendship");
        $parameters = [
            'file_id' => $relationship->getFile()->getId(),
            'villager_id' => $relationship->getVillager()->getId(),
            'friendship' => $relationship->getLevel()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $relationship->setId($this->db->lastInsertId());

        return $relationship;
    }

    // Get a relationship by its ID
    public function getRelationshipById(int $id) : Relationship
    {
        $query=$this->db->prepare("SELECT * FROM relationships WHERE relationships.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $relationship = new Relationship($this->getFileById($data['file_id']), $this->getVillagerById($data['villager_id']), $data['friendship_level']);
        $relationship->setId($data['id']);

        return $relationship;
    }
}

?>