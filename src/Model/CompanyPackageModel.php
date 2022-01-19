<?php

namespace Kobisi\CompanyService\Model;

use Kobisi\CompanyService\Core\DefaultModel;

class CompanyPackageModel extends DefaultModel
{
    public function attachCompanyWithPackage(array $args)
    {
        $this->database->execute('INSERT INTO company_packages (company_id, package_id, start_datetime, end_datetime) VALUES(?,?,?,?)', array_values($args));
    }

    public function getByCompanyId(int $companyId)
    {
        return $this->database->getRow('SELECT * FROM company_packages WHERE company_id = ?', [$companyId]);
    }

}
