<?php

class PlayerSkillManager extends AbstractManager {
    // Add the skills to the database
    public function addSkill(PlayerSkill $skill) : PlayerSkill
    {
        $query=$this->db->prepare("INSERT INTO player_skills")
    }
}

?>