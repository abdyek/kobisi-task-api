<?php

namespace Kobisi\CompanyService\Model;

use Kobisi\CompanyService\Core\DefaultModel;

class PackageModel extends DefaultModel
{
    public function getAll()
    {
        return $this->database->getRows('SELECT * FROM packages');
    }

    public function getById(int $id)
    {
        return $this->database->getRow('SELECT * FROM packages WHERE id = ?', [$id]);
    }
}
