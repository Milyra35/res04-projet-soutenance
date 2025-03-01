<?php

class PlayerProgressManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }
    
    // Add the fie to the database
    public function addProgress(PlayerProgress $player) : PlayerProgress
    {
        $exist = $this->db->prepare("SELECT * FROM player_progress WHERE file_id = :file_id AND character_name = :name");
        $parameters=[
            'file_id' => $player->getFile()->getId(),
            'name' => $player->getPlayerName()
        ];
        $exist->execute($parameters);
        $existingProgress = $exist->fetch(PDO::FETCH_ASSOC);

        if(!$existingProgress)
        {
            $insert=$this->db->prepare("INSERT INTO player_progress 
            (
                file_id,
                character_name,
                `money`,
                health,
                energy,
                cat,
                dog,
                pet_name,
                is_married,
                has_children,
                spouse
            )
            VALUES (
                :file_id,
                :character_name,
                :money,
                :health,
                :energy,
                :cat,
                :dog,
                :pet_name,
                :is_married,
                :has_children,
                :spouse
            )");
            $insertParam = [
                'file_id' => $player->getFile()->getId(),
                'character_name' => $player->getPlayerName(),
                'money' => $player->getMoney(),
                'health' => $player->getHealth(),
                'energy' => $player->getEnergy(),
                'cat' => $player->getCat() ? 1 : 0,
                'dog' => $player->getDog() ? 1 : 0,
                'pet_name' => $player->getPetName(),
                'is_married' => $player->getIsMarried() ? 1 : 0,
                'has_children' => $player->getHasChildren() ? 1 : 0,
                'spouse' => $player->getSpouse()
            ];
            $insert->execute($insertParam);

            $player->setId($this->db->lastInsertId());
        }
        else
        {
            $update = $this->db->prepare("UPDATE player_progress SET
                file_id = :file_id,
                character_name = :name,
                `money` = :money,
                health = :health,
                energy = :energy,
                cat = :cat,
                dog = :dog,
                pet_name = :pet_name,
                is_married = :is_married,
                has_children = :has_children,
                spouse = :spouse
                WHERE file_id = :file_id AND character_name = :name");
            $updateParam = [
                'file_id' => $player->getFile()->getId(),
                'name' => $player->getPlayerName(),
                'money' => $player->getMoney(),
                'health' => $player->getHealth(),
                'energy' => $player->getEnergy(),
                'cat' => $player->getCat() ? 1 : 0,
                'dog' => $player->getDog() ? 1 : 0,
                'pet_name' => $player->getPetName(),
                'is_married' => $player->getIsMarried() ? 1 : 0,
                'has_children' => $player->getHasChildren() ? 1 : 0,
                'spouse' => $player->getSpouse()
            ];
            $update->execute($updateParam);
        }
        
        return $player;
    }

    // Get the progress by its file ID
    public function getProgressById(int $id) : PlayerProgress
    {
        $query=$this->db->prepare("SELECT * FROM player_progress WHERE player_progress.file_id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $progress = new PlayerProgress(
            $this->fm->getFileById($data['file_id']),
            $data['character_name'],
            $data['money'],
            $data['health'],
            $data['energy'],
            $data['cat'],
            $data['dog'],
            $data['pet_name'],
            $data['is_married'],
            $data['has_children']
        );
        $progress->setSpouse($data['spouse']);
        $progress->setId($data['id']);

        return $progress;
    }

    // Delete a progress player by file id
    public function deletePlayerByFile(int $id)
    {
        $query=$this->db->prepare("DELETE FROM player_progress WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
    }
}

?>