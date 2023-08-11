<?php

abstract class AbstractController {
    public function render(string $view, array $values, string $file = "users") : void
    {
        $template = $view;
        $folder = $file;
        $data = $values;
        require "./templates/$folder/layout.phtml";
    }

    public function toJson(array $data)
    {
        echo json_encode($data);
    }
}

?>