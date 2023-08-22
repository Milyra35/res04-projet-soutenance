<?php

class PossessedItemManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }
    
    // Add an item to the database
    public function addPossessedItem(PossessedItem $item) : PossessedItem
    {
        $query=$this->db->prepare("SELECT * FROM possessed_items WHERE file_id = :file_id AND name = :name");
        $parameters= [
            'file_id' => $item->getFile()->getId(),
            'name' => $item->getName()
        ];
        $query->execute($parameters);
        $existingItem = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingItem)
        {
            $insert=$this->db->prepare("INSERT INTO possessed_items (file_id, name, amount)
                                    VALUES (:file_id, :name, :amount)");
            $insertParam=[
                'file_id' => $item->getFile()->getId(),
                'name' => $item->getName(),
                'amount' => $item->getAmount()
            ];
            $insert->execute($insertParam);

            $item->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE possessed_items SET
                file_id = :file_id,
                name = :name,
                amount = :amount
                WHERE file_id = :file_id AND name = :name");
            $updateParam= [
                'file_id' => $item->getFile()->getId(),
                'name' => $item->getName(),
                'amount' => $item->getAmount()
            ];
            $update->execute($updateParam);
        }
        
        return $item;
    }

    // Get the items from a file
    public function getItemsFromFile(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM possessed_items WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $items = [];

        foreach($data as $item)
        {
            $newItem = new PossessedItem($this->fm->getFileById($item['file_id']), $item['name'], $item['amount']);
            $newItem->setId($item['id']);
            $items[] = $newItem;
        }

        return $items;
    }
}

?>