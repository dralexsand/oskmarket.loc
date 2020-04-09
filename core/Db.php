<?php

class Db
{

    private static $instance;
    private $pdo;

    public function __construct()
    {
        $dbOptions = (require __DIR__ . '/db_settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /* queries */

    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function queryExecute(string $sql, array $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($params);
    }

    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }

}