<?php

class PossessedItemManager extends AbstractManager {
    // Add an item to the database
    public function addPossessedItem(PossessedItem $item) : PossessedItem
    {
        $query=$this->db->prepare("INSERT INTO possessed_items (file_id, name, amount)
                                    VALUES (:file_id, :name, :amount)");
        $parameters=[
            'file_id' => $item->getFile()->getId(),
            'name' => $item->getName(),
            'amount' => $item->getAmount()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $item->setId($this->db->lastInsertId());

        return $item;
    }

    // Get the item by ID
    public function getPossessedItemById(innt $id) : PossessedItem
    {
        $query=$this->db->prepare("SELECT * FROM possessed_items WHERE id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
        
        $data=$query->fetch(PDO::FETCH_ASSOC);
        $item = new PossessedItem($this->getFileById($data['id']), $data['name'], $data['amount']);
        $item->setId($data['id']);

        return $item;
    }
}

?>