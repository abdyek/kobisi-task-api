<?php

namespace Kobisi\CompanyService\Model;

use Kobisi\CompanyService\Core\DefaultModel;

class CompanyModel extends DefaultModel
{
    public function create(array $args)
    {
        $this->database->execute('INSERT INTO companies (site_url, name, last_name, company_name, email, password) VALUES(?,?,?,?,?,?)', array_values($args));
    }

    public function getByEmail(string $email): ?array
    {
        return $this->database->getRow('SELECT id FROM companies WHERE email = ?', [$email]);
    }

}
