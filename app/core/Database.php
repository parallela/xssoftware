<?php

namespace App\Core;

use PDO;

class Database
{
    protected PDO $dbInstance;

    public function __construct()
    {
        $config = require BASE_PATH.'/app/config.php';
        $databaseConfig = $config['db'];

       $this->dbInstance = new PDO(
           "mysql:host={$databaseConfig['hostname']};dbname={$databaseConfig['database']};charset=utf8mb4",
           $databaseConfig['username'], $databaseConfig['password']
       );

      // error mode for debug
       $this->dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function delete(string $query, array $params): bool
    {
        return $this->dbInstance->prepare($query)->execute($params);
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function insert(string $query, array $params): bool
    {
        return $this->dbInstance->prepare($query)->execute($params);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array|false
     */
    public function query(string $query, array $params)
    {
        $queryExec = $this->dbInstance->prepare(
            $query
        );

        $queryExec->execute($params);

        return $queryExec->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array|false
     */
    public function fetchOne(string $query, array $params)
    {
        $queryExec = $this->dbInstance->prepare(
            $query
        );

        $queryExec->execute($params);

        return $queryExec->fetch(PDO::FETCH_ASSOC);
    }
}