<?php

class ItemController extends AbstractController {
    private ItemManager $im;
    private PictureManager $pm;

    public function __construct()
    {
        $this->im = new ItemManager();
        $this->pm = new PictureManager();
    }
}

?>