<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Endpoint;

class Core
{
    protected Endpoint $endpoint;

    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
