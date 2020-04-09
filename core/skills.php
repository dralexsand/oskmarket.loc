<?php

class Skills
{
    private $table;

    public function __construct()
    {
        $this->table = 'skills';
    }

    public static function getAllSkills()
    {
        require_once __DIR__ . '/model.php';
        return Model::getAll('skills');
    }

    public static function getSkillById($id)
    {
        require_once __DIR__ . '/model.php';
        return Model::getNameById('skills', $id);
    }

    public function deleteSkillById($id)
    {
        require_once __DIR__ . '/model.php';
        return Model::deleteById($this->table, $id);
    }

    public function insertSkill($data)
    {
        require_once __DIR__ . '/model.php';
        return Model::insert($this->table, $data);
    }

    public function updateSkill($data, $id)
    {
        require_once __DIR__ . '/model.php';
        return Model::update($this->table, $data, $id);
    }

    public static function getRandomSkills()
    {
        $skills = self::getAllSkills();
        $random_amount_skills = rand(0, sizeof($skills) - 1);

        if($random_amount_skills == 0 ) return [];

        $ids = [];
        foreach ($skills as $skill) {
            $ids[] = $skill->id;
        }

        $skills_ids = [];
        $i = 1;
        while ($i <= $random_amount_skills) {
            $random_i = rand(0, sizeof($ids) - 1);
            $skills_ids[] = $ids[$random_i];
            unset($ids[$random_i]);
            sort($ids);
            $i++;
        }
        return $skills_ids;
    }


}