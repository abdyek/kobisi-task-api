<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Core;

class Config extends Core
{
    private array $requiredMap;
    private array $authorization;
    private string $secret;
    private array $database;

    public function __construct()
    {
        $this->requiredMap = [];
        $this->authorization = [];
    }

    public function getRequiredMap(): array
    {
        return $this->requiredMap;
    }

    public function setRequiredMap(array $requiredMap): void
    {
        $this->requiredMap = $requiredMap;
    }

    public function getAuthorization(): array
    {
        return $this->authorization;
    }

    public function setAuthorization(array $authMap): void
    {
        $this->authorization = $authMap;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    public function getDatabase(): array
    {
        return $this->database;
    }

    public function setDatabase(array $database): void
    {
        $this->database = $database;
    }

}
