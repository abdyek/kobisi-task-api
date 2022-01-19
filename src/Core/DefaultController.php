<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Endpoint;
use Kobisi\CompanyService\Core\Core;

class DefaultController extends Core
{
    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    private function getName(): string
    {
        $piece = explode('\\', get_class($this));
        return end($piece);
    }

    public function run(string $actionMethod)
    {
        $e = $this->endpoint;
        if(!$e->getAuthenticator()->check($this->getName(), $actionMethod)) {
            $e->getResponse()->forbidden();
        }
        $e->getRequest()->mergeData();
        if(!$e->getValidator()->check($this->getName(), $actionMethod)) {
            $e->getResponse()->badRequest();
        }
        if(!$e->getDatabase()->connect()) {
            $e->getResponse()->serviceUnavailable();
        }
        $this->{$actionMethod}();
        $e->getResponse()->serve();
    }


}
