<?php

class LocationManager extends AbstractManager {
    // Add a location to the database
    public function addLocation(Location $location) : Location
    {
        $query=$this->db->prepare("INSERT INTO locations (file_id, name, is_discovered)
                                    VALUES (:file_id, :name, :is_discovered)");
        $parameters= [
            'file_id' => $location->getFile()->getId(),
            'name' => $location->getName(),
            'is_discovered' => $location->getIsDiscovered()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $location->setId($this->db->lastInsertId());

        return $location;
    }

    // Get all the locations
    public function getAllLocations() : array
    {
        $query=$this->db->prepare("SELECT * FROM locations");
        $query->execute();
        $data=$query->fetchAll(PDO::FETCH_ASSOC);

        $locations = [];

        foreach($data as $location)
        {
            $newLoc = new Location($this->getFileById($location['file_id']), $location['name'], $location['is_discovered']);
            $newLoc->setId($location['id']);
            $locations[] = $newLoc;
        }

        return $locations;
    }
}

?>