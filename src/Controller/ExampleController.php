<?php

namespace Kobisi\CompanyService\Controller;

use Kobisi\CompanyService\Core\DefaultController;

class ExampleController extends DefaultController
{
    public function create()
    {
        $this->endpoint->getResponse()->setContent([
            'example' => 'example'
        ]);
    }
}
