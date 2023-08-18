<?php

class PlayerSkillManager extends AbstractManager {
    private FileManager $fm;

    public function __construct()
    {
        parent::__construct();
        $this->fm = new FileManager();
    }

    // Add the skills to the database
    public function addSkill(PlayerSkill $skill) : PlayerSkill
    {
        // I check if the skill already exists
        $exist = $this->db->prepare("SELECT * FROM player_skills WHERE file_id = :file_id AND `name` = :name");
        $parameters=[
            'file_id' => $skill->getFile()->getId(),
            'name' => $skill->getName()
        ];
        $exist->execute($parameters);
        $existingSkill = $exist->fetch(PDO::FETCH_ASSOC);

        if(!$existingSkill)
        {
            $query=$this->db->prepare("INSERT INTO player_skills (file_id, `name`, `level`)
                                    VALUES (:file_id, :name, :level)");
            $parameter=[
                'file_id' => $skill->getFile()->getId(),
                'name' => $skill->getName(),
                'level' => $skill->getLevel()
            ];
            $query->execute($parameter);

            // $data=$query->fetch(PDO::FETCH_ASSOC);
            $skill->setId($this->db->lastInsertId());

            return $skill;
        }
        else
        {
            $query=$this->db->prepare("INSERT INTO player_skills (file_id, `name`, `level`)
                                    VALUES (:file_id, :name, :level)
                                    ON DUPLICATE KEY UPDATE `level` = VALUES(`level`)");
            $parameter=[
                'file_id' => $skill->getFile()->getId(),
                'name' => $skill->getName(),
                'level' => $skill->getLevel()
            ];
            $query->execute($parameter);

            $skill->setId($this->db->lastInsertId());

            return $skill;
        }
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