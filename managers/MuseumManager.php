<?php

class MuseumManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }
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
                file_id = :file_id,
                name = :name,
                has = :has
                WHERE file_id = :file_id AND name = :name");
            $updateParam = [
                'file_id' => $item->getFile()->getId(),
                'name' => $item->getName(),
                'has' => $item->getHas()
            ];
            $update->execute($updateParam);
        }

        return $item;
    }

    // Get all the objects by File
    public function getMuseumItemsByFile(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM museum WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $items = [];

        foreach($data as $item)
        {
            $newItem = new Museum($this->fm->getFileById($item['file_id']), $item['name'], $item['has']);
            $newItem->setId($item['id']);
            $items[] = $newItem;
        }

        return $items;
    }
}

?>