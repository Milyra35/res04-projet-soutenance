<?php

class StatisticManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }

    // Add statistics to the database
    public function addStatistics(Statistic $stat) : Statistic
    {
        $query=$this->db->prepare("SELECT * FROM statistics WHERE file_id = :file_id");
        $parameters = [
            'file_id' => $stat->getFile()->getId()
        ];
        $query->execute($parameters);
        $existingStat = $query->fetch(PDO::FETCH_ASSOC);

        if(!$existingStat)
        {
            $insert=$this->db->prepare("INSERT INTO statistics (file_id, hours_played, days_spent, seasons_passed, fish_catched)
                                VALUES (:file_id, :hours, :days, :seasons, :fish)");
            $insertParam=[
                'file_id' => $stat->getFile()->getId(),
                'hours' => $stat->getHoursPlayed(),
                'days' => $stat->getDaysSpent(),
                'seasons' => $stat->getSeasonsPassed(),
                'fish' => $stat->getFishCatched()
            ];
            $insert->execute($insertParam);

            $stat->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE statistics SET 
                file_id = :file_id,
                hours_played = :hours,
                days_spent = :days,
                seasons_passed = :seasons,
                fish_catched = :fish
                WHERE file_id = :file_id");
            $updateParam= [
                'file_id' => $stat->getFile()->getId(),
                'hours' => $stat->getHoursPlayed(),
                'days' => $stat->getDaysSpent(),
                'seasons' => $stat->getSeasonsPassed(),
                'fish' => $stat->getFishCatched()
            ];
            $update->execute($updateParam);
        }
        
        return $stat;
    }

    // Get the stats by their file
    public function getStatByFile(int $id) : Statistic
    {
        $query=$this->db->prepare("SELECT * FROM statistics WHERE file_id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);
        $data=$query->fetch(PDO::FETCH_ASSOC);

        $newStat = new Statistic($this->fm->getFileById($data['file_id']), $data['hours_played'], $data['days_spent'], $data['seasons_passed'], $data['fish_catched']);
        $newStat->setId($data['id']);

        return $newStat;
    }

    // Get all the stats to display in the back-office
    public function getAllStats() : array
    {
        $query=$this->db->prepare("SELECT * FROM statistics");
        $query->execute();
        $data=$query->fetchAll(PDO::FETCH_ASSOC);

        $stats = [];

        foreach($data as $stat)
        {
            $newStat = new Statistic($this->fm->getFileById($stat['file_id']), $stat['hours_played'], $stat['days_spent'], $stat['seasons_passed'], $stat['fish_catched']);
            $newStat->setId($stat['id']);
            $stats[] = $newStat;
        }

        return $stats;
    }
}

?>