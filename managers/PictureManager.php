<?php

class PictureManager extends AbstractManager {
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

    // Add a picture
    public function addPicture(Picture $picture) : Picture
    {
        $query=$this->db->prepare("INSERT INTO pictures (name, url) VALUES (:name, :url)");
        $parameters=[
            'name' => $picture->getName(),
            'url' => $picture->getUrl(),
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $data->setId($this->db->lastInsertId());

        return $picture;
    }
}

?>