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
        $query = $this->db->prepare("SELECT * FROM player_skills WHERE file_id = :file_id AND `name` = :name AND `level` = :level");
        $parameters = [
            'file_id' => $skill->getFile()->getId(),
            'name' => $skill->getName(),
            'level' => $skill->getLevel()
        ];
        $query->execute($parameters);
        $existingSkill = $query->fetch(PDO::FETCH_ASSOC);

        if (!$existingSkill) 
        {
            // Skill doesn't exist, insert it
            $insertQuery = $this->db->prepare("INSERT INTO player_skills (file_id, `name`, `level`)
                                        VALUES (:file_id, :name, :level)");
            $insertQuery->execute($parameters);
            $skill->setId($this->db->lastInsertId());
        } 
        else 
        {
            // Skill exists, update its level
            $updateQuery = $this->db->prepare("UPDATE player_skills SET `level` = :level WHERE file_id = :file_id AND `name` = :name");
            $updateParameters = [
                'file_id' => $skill->getFile()->getId(),
                'name' => $skill->getName(),
                'level' => $skill->getLevel()
            ];
            $updateQuery->execute($updateParameters);
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

    // Get the skills of the same file
    public function getSkillsByFile(int $id) : array
    {
        $query=$this->db->prepare("SELECT * FROM player_skills WHERE file_id = :file_id");
        $parameters=['file_id' => $id];
        $query->execute($parameters);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $skills = [];

        foreach($data as $skill)
        {
            $newSkill = new PlayerSkill($this->fm->getFileById($skill['file_id']), $skill['name'], $skill['level']);
            $newSkill->setId($skill['id']);
            $skills[] = $newSkill;
        }

        return $skills;
    }
}

?>