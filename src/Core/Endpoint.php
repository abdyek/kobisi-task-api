<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Request;
use Kobisi\CompanyService\Core\Response;
use Kobisi\CompanyService\Core\Config;
use Kobisi\CompanyService\Core\Authenticator;
use Kobisi\CompanyService\Core\Validator;
use Kobisi\CompanyService\Core\Database;

class Endpoint
{
    private Request $request;
    private Response $response;
    private Config $config;
    private Authenticator $authenticator;
    private Validator $validator;
    private Database $database;

    public function __construct(Request $request, Response $response, Config $config, Authenticator $authenticator, Validator $validator, Database $database)
    {
        $this->request = $request;
        $this->response = $response;
        $this->config = $config;
        $this->authenticator = $authenticator;
        $this->validator = $validator;
        $this->database = $database;
        $this->setThis();
    }

    public function setThis()
    {
        $this->request->setEndpoint($this);
        $this->response->setEndpoint($this);
        $this->config->setEndpoint($this);
        $this->authenticator->setEndpoint($this);
        $this->validator->setEndpoint($this);
        $this->database->setEndpoint($this);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function getAuthenticator(): Authenticator
    {
        return $this->authenticator;
    }

    public function getValidator(): Validator
    {
        return $this->validator;
    }
    
    public function getDatabase(): Database
    {
        return $this->database;
    }

}
