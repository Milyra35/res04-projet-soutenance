<?php

class MuseumManager extends AbstractManager {
    // Add an item to the museum
    public function addItem(Museum $item) : Museum
    {
        $query=$this->db->prepare("SELECT * FROM museum WHERE file_id = :file_id AND name = :name");
        $parameters = [
            'file_id' => $item->getFile()->getId(),
            'name' => $item->getName()
        ];
        $query->execute($parameters);
        $existingItem = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingItem)
        {
            $insert=$this->db->prepare("INSERT INTO museum (file_id, name, has)
                                    VALUES (:file_id, :name, :has)");
            $insertParam = [
                'file_id' => $item->getFile()->getId(),
                'name' => $item->getName(),
                'has' => $item->getHas()
            ];
            $insert->execute($insertParam);

            $item->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE museum SET 
                name = :name,
                has = :has
                WHERE file_id = :file_id");
            $updateParam = [
                'file_id' => $item->getFile()->getId(),
                'name' => $item->getName(),
                'has' => $item->getHas()
            ];
            $update->execute($updateParam);
        }

        return $item;
    }
}

?>