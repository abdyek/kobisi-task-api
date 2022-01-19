<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Core;

class Database extends Core
{
    private \PDO $connect;

    public function connect(): bool
    {
        $config = $this->endpoint->getConfig()->getDatabase();
        try {
            $this->connect = new \PDO($config['dsn'], $config['username'], $config['password']);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getRow(string $sql, array $parameters = null): ?array
    {
        $query = $this->connect->prepare($sql);
        $query->execute($parameters);
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return ($row === false ? null: $row);
    }

    public function getRows(string $sql, array $parameters = null)
    {
        $query = $this->connect->prepare($sql);
        $query->execute($parameters);
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
        return ($rows === false ? null: $rows);
    }

    public function execute(string $sql, $parameters = null)
    {
        $exec = $this->connect->prepare($sql);
        $exec->fetch(\PDO::FETCH_ASSOC);
        $exec->execute($parameters);
    }

}
