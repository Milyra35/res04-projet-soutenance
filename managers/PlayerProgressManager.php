<?php

class PlayerProgressManager extends AbstractManager {
    // Add the fie to the database
    public function addProgress(PlayerProgress $player) : PlayerProgress
    {
        $query=$this->db->prepare("INSERT INTO player_progress 
        (
            file_id,
            character_name,
            experience_level,
            money,
            health,
            energy,
            cat,
            dog,
            pet_name,
            is_married,
            has_children
        )
        VALUES (
            :file_id,
            :character_name,
            :experience_level;
            :money,
            :health,
            :energy,
            :cat,
            :dog,
            :pet_name,
            :is_married,
            :has_children
        )");
        $parameters = [
            'file_id' => $player->getFile()->getId(),
            'character_name' => $player->getPlayerName(),
            'experience_level' => $player->getExperienceLevel(),
            'money' => $player->getMoney(),
            'health' => $player->getHealth(),
            'energy' => $player->getEnergy(),
            'cat' => $player->getCat(),
            'dog' => $player->getDog(),
            'pet_name' => $player->getPetName(),
            'is_married' => $player->getIsMarried(),
            'has_children' => $player->getHasChildren()
        ];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $player->setId($this->db->lastInsertId());

        return $player;
    }

    // Get the progress by its ID
    public function getProgressById(int $id) : PlayerProgress
    {
        $query=$this->db->prepare("SELECT * FROM player_progress WHERE player_progress.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $progress = new PlayerProgress(
            $this->getFileById($data['file_id']),
            $data['character_name'],
            $data['experience_level'],
            $data['money'],
            $data['health'],
            $data['energy'],
            $data['cat'],
            $data['dog'],
            $data['pet_name'],
            $data['is_married'],
            $data['has_children']
        );
        $progress->setId($data['id']);

        return $progress;
    }
}

?>