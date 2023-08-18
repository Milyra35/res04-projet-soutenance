<?php

class PlayerSkillManager extends AbstractManager {
    // Add the skills to the database
    public function addSkill(PlayerSkill $skill) : PlayerSkill
    {
        $exist = $this->db->prepare("SELECT * FROM player_skills WHERE file_id = :file_id AND name = :name");
        $parameters=[
            'file_id' => $skill->getFile()->getId(),
            'name' => $skill->getName()
        ];
        $existingSkill = $exist->fetch(PDO::FETCH_ASSOC);

        if(!$existingSkill)
        {
            $query=$this->db->prepare("INSERT INTO player_skills (file_id, name, level)
                                    VALUES (:file_id, :name, :level)");
            $parameters=[
                'file_id' => $skill->getFile()->getId(),
                'name' => $skill->getName(),
                'level' => $skill->getLevel()
            ];
            $query->execute($parameters);

            $data=$query->fetch(PDO::FETCH_ASSOC);
            $skill->setId($this->db->lastInsertId());
        }

        return $skill;
    }

    // Get the player skills by its id
    public function getSkillById(int $id) : PlayerSkill
    {
        $query=$this->db->prepare("SELECT * FROM players_skills WHERE players_skills.id = :id");
        $parameters=['id' => $id];
        $query->execute($parameters);

        $data=$query->fetch(PDO::FETCH_ASSOC);
        $skill = new PlayerSkill($this->getFileById($data['file_id']), $data['name'], $data['level']);
        $skill->setId($data['id']);

        return $skill;
    }
}

?>