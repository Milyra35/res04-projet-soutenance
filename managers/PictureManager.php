<?php

class PictureManager extends AbstractManager {
    // Get a picture by its ID
    public function getPictureById(int $id) : Picture
    {
        $query=$this->db->prepare("SELECT * FROM pictures WHERE pictures.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $picture = new Picture($data['name'], $data['url'], $data['alt']);
        $picture->setId($data['id']);

        return $picture;
    }

    // Get a picture by its name
    public function getPictureByName(string $name) : Picture
    {
        $query=$this->db->prepare("SELECT * FROM pictures WHERE pictures.name = :name");
        $parameters= ['name' => $name];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $picture = new Picture($data['name'], $data['url'], $data['alt']);
        $picture->setId($data['id']);

        return $picture;
    }

    // Add a picture
    public function addPicture(Picture $picture) : Picture
    {
        $query=$this->db->prepare("INSERT INTO pictures (name, url, alt) VALUES (:name, :url, :alt)");
        $parameters=[
            'name' => $picture->getName(),
            'url' => $picture->getUrl(),
            'alt' => $picture->getAlt()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $data->setId($this->db->lastInsertId());

        return $picture;
    }
}

?>