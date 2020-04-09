<?php

class City
{

    private $table;

    public function __construct()
    {
        $this->table = 'city';
    }

    public static function getRandomCity()
    {
        $cities = self::getAllCitys();
        $random = rand(0, sizeof($cities) - 1);

        $ids = [];
        foreach ($cities as $city) {
            $ids[] = $city->id;
        }
        return $ids[$random];
    }

    public static function getAllCitys()
    {
        require_once __DIR__ . '/model.php';
        return Model::getAll('city');
    }

    public function getCityById($id){
        require_once __DIR__ . '/model.php';
        return Model::getNameById($this->table, $id);
    }

    public function deleteCityById($id){
        require_once __DIR__ . '/model.php';
        return Model::deleteById($this->table, $id);
    }

    public function insertCity($data){
        require_once __DIR__ . '/model.php';
        return Model::insert($this->table, $data);
    }
    public function updateCity($data, $id){
        require_once __DIR__ . '/model.php';
        return Model::update($this->table, $data, $id);
    }

}