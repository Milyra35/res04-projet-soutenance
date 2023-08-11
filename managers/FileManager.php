<?php

class FileManager extends AbstractManager {
    // Get all the files (for the admin part)
    public function getAllGames() : array
    {
        $query=$this->db->prepare("SELECT * FROM saves_files");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $files = [];

        foreach($data as $file)
        { 
            $newFile = new SavedFile($this->getUserById($data['user_id']), $data['name'], $data['url']);
            $newFile->setId($file['id']);
            $files[] = $newFile;
        }

        return $files;
    }

    // Add the file to the database
    public function addFile(SavedFile $file) : SavedFile
    {
        $query=$this->db->prepare("INSERT INTO saved_files (user_id, name, url, upload_date)
                                    VALUES (:userId, :name, :url, :upload_date)");
        $parameters= [
            'userId'=> $file->getUser()->getId(),
            'name'=> $file->getName(),
            'url'=> $file->getUrl(),
            'upload_date'=> $file->getDate()
        ];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $file->setId($this->db->lastInsertId());

        return $file;
    }

    public function deleteFile(int $id) : void
    {
        $query=$this->db->prepare("DELETE FROM saved_files WHERE saved_files.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
    }

    // Get all the games by user
    public function getGamesByUser(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM saved_files WHERE user_id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $files=$query->fetchAll(PDO::FETCH_ASSOC);

        foreach($files as $file)
        {
            $file['user_id'] = $this->getUserById($file['user_id']);
        }

        return $files;
    }

    // Get a file by its ID
    public function getFileById(int $id) : SavedFile
    {
        $query=$this->db->prepare("SELECT * FROM saved_files WHERE saved_files.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);
        
    }
}

?>