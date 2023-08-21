<?php

class LocationManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }
    
    // Add a location to the database
    public function addLocation(Location $location) : Location
    {
        $query=$this->db->prepare("SELECT * FROM locations WHERE file_id = :file_id AND name = :name");
        $parameters= [
            'file_id' => $location->getFile()->getId(),
            'name' => $location->getName()
        ];
        $query->execute($parameters);
        $existingLocation = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingLocation)
        {
            $insert=$this->db->prepare("INSERT INTO locations (file_id, name, is_discovered)
                                    VALUES (:file_id, :name, :is_discovered)");
            $insertParam= [
                'file_id' => $location->getFile()->getId(),
                'name' => $location->getName(),
                'is_discovered' => $location->getIsDiscovered()
            ];
            $insert->execute($insertParam);

            $location->setId($this->db->lastInsertId());
        }
        else
        {
            $update=$this->db->prepare("UPDATE locations SET
                file_id = :file_id,
                name = :name,
                is_discovered = :is_discovered
                WHERE file_id = :file_id AND name = :name");
            $updateParam= [
                'file_id' => $location->getFile()->getId(),
                'name' => $location->getName(),
                'is_discovered' => $location->getIsDiscovered()
            ];
            $update->execute($updateParam);
        }
        
        return $location;
    }

    // Get all the locations from file
    public function getAllLocationsByFile(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM locations WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
        $data=$query->fetchAll(PDO::FETCH_ASSOC);

        $locations = [];

        foreach($data as $location)
        {
            $newLoc = new Location($this->fm->getFileById($location['file_id']), $location['name'], $location['is_discovered']);
            $newLoc->setId($location['id']);
            $locations[] = $newLoc;
        }

        return $locations;
    }
}

?>