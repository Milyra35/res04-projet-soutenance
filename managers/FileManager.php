<?php

class FileManager extends AbstractManager {
    // Get a role by its ID
    public function getRoleById(int $id) : Role
    {
        $query=$this->db->prepare("SELECT * FROM roles WHERE roles.id = :id");
        $parameters=['id'=> $id];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $role = new Role($id, $data["name"]);

        return $role;
    }
    
    // Get a file by its ID
    public function getFileById(int $id) : SavedFile
    {
        $query=$this->db->prepare("SELECT * FROM saved_files WHERE saved_files.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $file = new SavedFile($this->getUserById($data['user_id']), $data['name'], $data['url']);

        $file->setId($data['id']);
        $file->setDate($data['upload_date']);
        
        return $file;
    }

    // Get an user by its ID
    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User($data['username'], $data['password'], $data['email'], $this->getRoleById($data['role_id']));

        $user->setId($data['id']);
        $user->setRegistrationDate($data['registration_date']);

        return $user;
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
            $newFile = new SavedFile($this->getUserById($file['user_id']), $file['name'], $file['url']);
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
}

?>