<?php

class FileManager extends AbstractManager {
    private UserManager $um;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
    }

    // Get a file by its ID
    public function getFileById(int $id) : SavedFile
    {
        $query=$this->db->prepare("SELECT * FROM saved_files WHERE saved_files.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $file = new SavedFile($this->um->getUserById($data['user_id']), $data['name'], $data['url']);

        $file->setId($data['id']);
        $file->setDate($data['upload_date']);
        
        return $file;
    }

    // Get all the files (for the admin part)
    public function getAllGames() : array
    {
        $query=$this->db->prepare("SELECT * FROM saved_files");
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $files = [];

        foreach($data as $file)
        { 
            $newFile = new SavedFile($this->um->getUserById($file['user_id']), $file['name'], $file['url']);
            $newFile->setId($file['id']);
            $files[] = $newFile;
        }

        return $files;
    }

    // Add the file to the database
    public function addFile(SavedFile $file) : SavedFile
    {
        $exist = $this->db->prepare("SELECT * FROM saved_files WHERE name = :name");
        $parameters=['name' => $file->getName()];
        $exist->execute($parameters);
        $existingFile = $exist->fetch(PDO::FETCH_ASSOC);

        if(!$existingFile)
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
        }
        else
        {
            // Add DELETE and then re INSERT INTO it
        }

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
            $file['user_id'] = $this->um->getUserById($file['user_id']);
        }

        return $files;
    }

    // Get a game by its name
    public function getFileByName(string $name) : SavedFile
    {
        $query=$this->db->prepare("SELECT * FROM saved_files WHERE name = :name");
        $parameters=['name' => $name];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $file = new SavedFile($this->um->getUserById($data['user_id']), $data['name'], $data['url']);
        $file->setId($data['id']);
        $file->setDate($data['upload_date']);

        return $file;
    }
}

?>