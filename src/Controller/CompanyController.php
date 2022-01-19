<?php

namespace Kobisi\CompanyService\Controller;

use Kobisi\CompanyService\Core\DefaultController;

class CompanyController extends DefaultController
{
    public function register(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be register'
        ]);
    }

    public function login(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be login'
        ]);
    }

    public function check(): void
    {
        $this->endpoint->getResponse()->setContent([
            'message' => 'here is going to be check'
        ]);
    }
}
