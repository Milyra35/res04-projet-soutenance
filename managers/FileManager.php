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
            $newFile->setDate($file['upload_date']);
            $files[] = $newFile;
        }

        return $files;
    }

    // Add the file to the database
    public function addFile(SavedFile $file) : SavedFile
    {
        $query = $this->db->prepare("SELECT * FROM saved_files WHERE user_id = :user_id AND name = :name");
        $parameters=[
            'name' => $file->getName(),
            'user_id' => $file->getUser()->getId()
        ];
        $query->execute($parameters);
        $existingFile = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingFile)
        {
            $insert=$this->db->prepare("INSERT INTO saved_files (user_id, name, url, upload_date)
                                    VALUES (:userId, :name, :url, :upload_date)");
            $insertParam= [
                'userId'=> $file->getUser()->getId(),
                'name'=> $file->getName(),
                'url'=> $file->getUrl(),
                'upload_date'=> $file->getDate()
            ];
            $insert->execute($insertParam);

            $file->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE saved_files SET 
                url = :url,
                upload_date = :upload_date
                WHERE user_id = :user_id AND name = :name");
            $updateParams = [
                'user_id'=> $file->getUser()->getId(),
                'name'=> $file->getName(),
                'url'=> $file->getUrl(),
                'upload_date'=> $file->getDate()
            ];
            $update->execute($updateParams);
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

    // Get everything in the database to make a backup
    // public function getAllDatas() : array
    // {
    //     $query=$this->db->prepare("SELECT * FROM books, community_center, 
    //                                             items, locations, museum, 
    //                                             pictures, player_progress, 
    //                                             player_skills, possessed_items, 
    //                                             relationships, roles, saved_files, 
    //                                             statistics, users, villagers, 
    //                                             villagers_planning");
    //     $query->execute();
    //     $data = $query->fetchAll(PDO::FETCH_ASSOC);
    //     $datas = array('data' => $data);

    //     echo json_encode($datas);

    //     return $datas;
    // }
}

?>