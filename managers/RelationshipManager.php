<?php

class RelationshipManager extends AbstractManager {
    private FileManager $fm;
    private VillagerManager $vm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
        $this->vm = new VillagerManager();
    }

    // Add a relationship in the database
    public function addRelationship(Relationship $relationship) : Relationship
    {
        $query = $this->db->prepare("SELECT * FROM relationships WHERE file_id = :file_id AND villager_id = :villager_id");
        $parameters= [
            'file_id' => $relationship->getFile()->getId(),
            'villager_id' => $relationship->getVillager()->getId()
        ];
        $query->execute($parameters);
        $existingRelationship = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingRelationship)
        {
            $insert=$this->db->prepare("INSERT INTO relationships (file_id, villager_id, friendship_level)
                                    VALUES (:file_id, :villager_id, :friendship)");
            $insertParam = [
                'file_id' => $relationship->getFile()->getId(),
                'villager_id' => $relationship->getVillager()->getId(),
                'friendship' => $relationship->getLevel()
            ];
            $insert->execute($insertParam);

            $relationship->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE relationships SET
                file_id = :file_id,
                villager_id = :villager_id,
                friendship_level = :friendship
                WHERE file_id = :file_id AND villager_id = :villager_id");
            $updateParam = [
                'file_id' => $relationship->getFile()->getId(),
                'villager_id' => $relationship->getVillager()->getId(),
                'friendship' => $relationship->getLevel()
            ];
            $update->execute($updateParam);
        }

        return $relationship;
    }

    // Get a relationship by its ID
    // public function getRelationshipById(int $id) : Relationship
    // {
    //     $query=$this->db->prepare("SELECT * FROM relationships WHERE relationships.id = :id");
    //     $parameters=['id' => $id];
    //     $query->execute($parameters);

    //     $data=$query->fetch(PDO::FETCH_ASSOC);
    //     $relationship = new Relationship($this->getFileById($data['file_id']), $this->getVillagerById($data['villager_id']), $data['friendship_level']);
    //     $relationship->setId($data['id']);

    //     return $relationship;
    // }

    // Get the relationships by file
    public function getRelationshipsByFile(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM relationships WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $relationships = [];

        foreach($data as $relation)
        {
            $newRelationship = new Relationship($this->fm->getFileById($relation['file_id']), $this->vm->getVillagerById($relation['villager_id']), $relation['friendship_level']);
            $newRelationship->setId($relation['id']);
            $relationships[] = $newRelationship;
        }

        return $relationships;
    }

    // Delete relationships by file id
    public function deleteRelationshipByFile(int $id)
    {
        $query=$this->db->prepare("DELETE FROM relationships WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
    }
}

?>