<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Database;

class DefaultModel
{
    protected Database $database;

    public function setDatabase(Database $database)
    {
        $this->database = $database;
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }
}
