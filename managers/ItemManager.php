<?php

class ItemManager extends AbstractManager {
    private PictureManager $pm;

    public function __construct()
    {
        parent::__construct();
        $this->pm = new PictureManager();
    }
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

    // Add an item to the database
    public function addItem(Item $item) : Item
    {
        $query=$this->db->prepare("INSERT INTO items (picture_id, type, name, description)
                                    VALUES (:picture_id, :type, :name, :description)");
        $parameters = [
            'picture_id' => $item->getPicture()->getId(),
            'type' => $item->getType(),
            'name' => $item->getName(),
            'description' => $item->getDescription()
        ];
        $query->execute($parameters);

        $item->setId($this->db->lastInsertId());

        return $item;
    }

    // Get all items
    public function getAllItems() : array
    {
        $query=$this->db->prepare("SELECT * FROM items");
        $query->execute();
        $data=$query->fetchAll(PDO::FETCH_ASSOC);

        $items = [];

        foreach($data as $item)
        {
            $newItem = new Item($this->pm->getPictureById($item['picture_id']), $item['type'], $item['name'], $item['description']);
            $newItem->setId($item['id']);
            $items[] = $newItem;
        }

        return $items;
    }

    // Get ann item by its id
    public function getItemById(int $id) : Item
    {
        $query=$this->db->prepare("SELECT * FROM items WHERE items.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO:FETCH_ASSOC);
        $item = new Item($this->getPictureById($data['picture_id']), $data['type'], $data['name'], $data['description']);
        $item->setId($data['id']);

        return $item;
    }
}

?>