<?php

class ItemController extends AbstractController {
    private ItemManager $im;
    private PictureManager $pm;

    public function __construct()
    {
        $this->im = new ItemManager();
        $this->pm = new PictureManager();
    }

    // Add a list of items in the database
    public function addItems()
    {
        $txtContent = file_get_contents('data/items.txt');
        $data = json_decode($txtContent);
        // var_dump($data);

        foreach($data as $item)
        {
            $name = $item->Item;
            $type = $item->Type;
            $description = $item->{'Item Description'};
            $picture = $this->pm->getPictureByName($name);

            $newItem = new Item($picture, $type, $name, $description);
            // var_dump($newItem);
            $this->im->addItem($newItem);
        }
    }
}

?>