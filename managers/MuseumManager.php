<?php

class MuseumManager extends AbstractManager {
    // Add an item to the museum
    public function addItem(Museum $item) : Museum
    {
        $query=$this->db->prepare("INSERT INTO museum (file_id, name, has)
                                    VALUES (:file_id, :name, :has)");
        $parameters = [
            'file_id' => $item->getFile()->getId(),
            'name' => $item->getName(),
            'has' => $item->getHas()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO:FETCH_ASSOC);
        $item->setId($this->db->lastInsertId());

        return $item;
    }
}

?>