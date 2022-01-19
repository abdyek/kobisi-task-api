<?php

namespace Kobisi\CompanyService\Controller;

use Kobisi\CompanyService\Core\DefaultController;

class PackageController extends DefaultController
{
    public function showPackages(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be showAll'
        ]);
    }

    public function set(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be set'
        ]);
    }
}
