<?php

class Model
{

    /**
     * @param $table
     * @return array|null
     */
    public static function getAll($table, $orderby='')
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . $table.$orderby;
        return $db->query($sql, []);
    }

    /**
     * @param $table
     * @param $id
     * @return mixed
     */
    public static function getNameById($table, $id)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "SELECT name FROM " . $table . " WHERE id in (?) LIMIT 1";
        return $db->query($sql, [$id])[0]->name;
    }

    /**
     * @param $table
     * @param $id
     * @return bool
     */
    public static function deleteById($table, $id)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "DELETE FROM " . $table . " WHERE id in (?) LIMIT 1";
        return $db->queryExecute($sql, [$id]);
    }

    /**
     * @param $table
     * @param $data
     * @return bool
     */
    public static function insert($table, $data)
    {
        $dublicate = self::isDublicate($table, $data);

        if (!$dublicate) {
            require_once __DIR__ . '/Db.php';
            $db = Db::getInstance();
            $fields = implode(',', array_keys($data));
            $q = implode(',', array_fill(0, sizeof($data), '?'));
            $sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $q . ")";
            $db->queryExecute($sql, array_values($data));
            return self::getLastId($table);
        }
        return false;
    }

    /**
     * @param $table
     * @param $data
     * @param $id
     * @return bool
     */
    public static function update($table, $data, $id)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $set = [];
        foreach ($data as $field => $value) {
            $params[] = $value;
            $set[] = $field . "=?";
        }
        $params[] = $id;
        $sql = "UPDATE " . $table . " SET " . implode('', $set) . " WHERE id in(?)";
        return $db->queryExecute($sql, $params);
    }

    /**
     * @param $table
     * @param $data
     * @return bool
     */
    public static function isDublicate($table, $data)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $where = [];
        //$params = [];
        foreach ($data as $field => $value) {
                //$params[] = $value;
                $where[] = " AND " . $field . "=? ";
        }
        $where_str = " WHERE 1 " . implode(' ', $where);
        $sql = "SELECT 1 FROM " . $table . $where_str;
        $result = $db->query($sql, array_values($data));
        return empty($result) ? false : true;
    }

    public static function getLastId($table)
    {
        require_once __DIR__ . '/Db.php';
        $db = Db::getInstance();
        $sql = "SELECT id FROM " . $table . " ORDER BY id DESC LIMIT 1";
        return $db->query($sql, [$id])[0]->id;
    }
}