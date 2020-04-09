<?php


class Users
{
    private $table;

    public function __construct()
    {
        $this->table = 'users';
    }

    public static function generateRandomUserName()
    {
        $listFirstNames = self::listFirstNames();
        $listLastNames = self::listLastNames();

        $random = rand(0, sizeof($listFirstNames) - 1);
        $firstName = $listFirstNames[$random];

        $random = rand(0, sizeof($listLastNames) - 1);
        $lastName = $listLastNames[$random];

        return $lastName." ".$firstName;
    }

    public static function getRandomUserName(){
        $duplicate = true;
        while (!$duplicate){
            $userName = self::generateRandomUserName();
            $duplicate = Model::isDublicate('users', ['name'=>$userName]);
        }
        return $userName;
    }

    public static function getAllUsers($orderby='')
    {
        require_once __DIR__ . '/model.php';
        return Model::getAll('users', $orderby);
    }

    public function getUserById($id){
        require_once __DIR__ . '/model.php';
        return Model::getNameById($this->table, $id);
    }

    public function deleteUserById($id){
        require_once __DIR__ . '/model.php';
        return Model::deleteById($this->table, $id);
    }

    public static function insertUser($data){
        require_once __DIR__ . '/model.php';
        return Model::insert('users', $data);
    }
    public function updateUser($data, $id){
        require_once __DIR__ . '/model.php';
        return Model::update($this->table, $data, $id);
    }
    
    

    public static function listFirstNames()
    {
        return [
            'Anastasia', 'Alex', 'Daemon', 'Max', 'Stephen', 'Anna', 'Maria', 'John', 'Henry',
            'Jack', 'Simon', 'Anthony', 'Daniel', 'Peter', 'David', 'Victor', 'Eric', 'Phil', 'Harry',
            'Paul', 'Juan', 'Marcus', 'Jesse', 'Andreas', 'Fred', 'Bruno', 'Diego', 'Luke', 'Timothy', 'Aaron',
            'James', 'Mason', 'Axel', 'Scott', 'Brandon'
        ];
    }

    public static function listLastNames()
    {
        return [
            'Lindelöf', 'Bailly', 'Jones', 'Maguire', 'Pogba', 'Mata', 'Martial', 'Rashford', 'Grant',
            'Lingard', 'Pereira', 'Andreas', 'Fernandes', 'Dalot', 'James', 'Romero', 'Shaw', 'Greenwood', 'Gomes',
            'Garner', 'McTominay', 'Williams', 'Phelan', 'Carrick', 'Dempsey', 'Pert', 'Hartis', 'Hawkins', 'Gaudino', 'Owen',
            'Clegg', 'Leng', 'Butt', 'Wood', 'Neil', 'Ryan', 'West', 'Mangnall', 'Bentley', 'Robson',
            'Duncan', 'Caretaker', 'McGuinness', 'Docherty', 'Atkinson'
        ];
    }


}

?>



