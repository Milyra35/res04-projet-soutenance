<?php

class AdminController extends AbstractController {
    private UserManager $um;

    public function __construct()
    {
        $this->um = new UserManager();
    }

    public function index()
    {
        $this->render("admin/layout.phtml", []);
    }
}

?>