<?php

class StatisticManager extends AbstractManager {
    // Add statistics to the database
    public function addStatistics(Statistic $stat) : Statistic
    {
        $query=$this->db->prepare("INSERT INTO statistics (file_id, hours_played, days_spent, seasons_passed, fish_catched)
                                VALUES (:file_id, :hours, :days, :seasons, :fish)");
        $parameters=[
            'file_id' => $stat->getFile()->getId(),
            'hours' => $stat->getHoursPlayed(),
            'days' => $stat->getDaysSpent(),
            'seasons' => $stat->getSeasonsPassed(),
            'fish' => $stat->getFishCatched()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $stat->setId($this->db->lastInsertId());

        return $stat;
    }

    // Get the stats by their ID
    public function getStatById(int $id) : Statistic
    {
        $query=$this->db->prepare("SELECT * FROM statistics WHERE id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $stat = new Statistic($this->getFileById($data['file_id']), $data['hours_played'], $data['days_spent'], $data['seasons_passed'], $data['fish_catched']);
        $stat->setId($data['id']);

        return $stat;
    }

    // Get all the stats to display in the back-office
    public function getAllStats() : array
    {
        $query=$this->db->prepare("SELECT * FROM statistics");
        $query->execute();
        $data=$query->fetch(PDO::FETCH_ASSOC);

        $stats = [];

        foreach($data as $stat)
        {
            $newStat = new Statistic($this->getFileById($stat['file_id']), $stat['hours_played'], $stat['days_spent'], $stat['seasons_passed'], $stat['fish_catched']);
            $newStat->setId($stat['id']);
            $stats[] = $newStat;
        }

        return $stats;
    }
}

?>