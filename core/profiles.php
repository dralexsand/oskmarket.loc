<?php

class Profiles
{
    private $table;

    public function __construct()
    {
        $this->table = 'profiles';
    }

    public static function createProfile()
    {

        require_once __DIR__ . '/Users.php';
        require_once __DIR__ . '/Skills.php';
        require_once __DIR__ . '/City.php';

        $username = Users::generateRandomUserName();
        $skills = Skills::getRandomSkills();
        $city = City::getRandomCity();

        $userdata = [
            'name' => $username,
            'city_id' => $city
        ];

        $user_id = Users::insertUser($userdata);

        $profiledata = [
            'user_id' => $user_id,
            'skills' => $skills
        ];
        self::insertProfile($profiledata);
    }

    public static function getProfile($user_id)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "
        SELECT city.name city_name, users.name 
        FROM users 
        JOIN city ON city.id=users.city_id
        WHERE users.id in(?) 
        LIMIT 1";
        $users_info = $db->query($sql, [$user_id])[0];

        $city_name = $users_info->city_name;
        $user_name = $users_info->name;

        $sql = "
        SELECT skills.name skill_name 
        FROM profiles 
        JOIN skills ON skills.id=profiles.skill_id
        WHERE user_id in(?)
        ";
        $profileInfo = $db->query($sql, [$user_id]);

        $skills = [];
        if (!empty($profileInfo)) {
            foreach ($profileInfo as $item) {
                $skills[] = $item->skill_name;
            }
        }

        return [
            'user_name' => $user_name,
            'city_name' => $city_name,
            'skills' => implode(', ', $skills)
        ];
    }

    public static function getProfiles()
    {
        require_once __DIR__ . '/Users.php';
        require_once __DIR__ . '/Db.php';
        $users = Users::getAllUsers(' ORDER BY id DESC');
        $profiles = [];
        foreach ($users as $user) {
            $profileInfo = self::getProfile($user->id);
            $profile = [
                'id' => $user->id,
                'city_name' => $profileInfo['city_name'],
                'skills' => $profileInfo['skills'],
                'user_name' => $profileInfo['user_name']
            ];
            $profiles[] = $profile;
        }

        return $profiles;
    }

    public function getProfiles0()
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "
        SELECT users.id, users.name, city.name city_name, skills.name skill_name
        FROM profiles
        JOIN users ON users.id=profiles.user_id
        LEFT JOIN skills ON skills.id=profiles.skill_id
        LEFT JOIN city ON city.id=users.city_id
        ";

        $items = $db->query($sql, []);
        $profiles = [];
        foreach ($items as $item) {
            $profiles[$item->id]['id'] = $item->id;
            $profiles[$item->id]['name'] = $item->name;
            $profiles[$item->id]['city'] = $item->city_name;
            $profiles[$item->id]['skill_name'][] = $item->skill_name;
        }

        $result = [];
        foreach ($profiles as $profile) {
            $result[] = $profile;
        }

        return $profiles;
    }

    public function getAllProfiles()
    {
        require_once __DIR__ . '/model.php';
        return Model::getAll($this->table);
    }

    public function getProfileById($id)
    {
        require_once __DIR__ . '/model.php';
        return Model::getNameById($this->table, $id);
    }

    public function deleteProfileById($id)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "DELETE FROM profiles WHERE user_id in (?) LIMIT 1";
        $db->queryExecute($sql, [$id]);

        $sql = "DELETE FROM users WHERE id in (?) LIMIT 1";
        return $db->queryExecute($sql, [$id]);
    }

    public static function insertProfile($data)
    {
        require_once __DIR__ . '/model.php';

        if (empty($data['skills'])) return;

        foreach ($data['skills'] as $skill) {
            $params = [
                'user_id' => $data['user_id'],
                'skill_id' => $skill
            ];
            $last_id = Model::insert('profiles', $params);
        }
        return $last_id;
    }

    public function updateProfile($data, $id)
    {
        require_once __DIR__ . '/model.php';
        return Model::update($this->table, $data, $id);
    }

}