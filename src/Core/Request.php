<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Core;

class Request extends Core
{
    private $method;
    private array $content;
    private $token;
    private $dataInUrl;

    public function __construct($method = null, $data = null, $token = null)
    {
        $this->method = $method ?? $_SERVER['REQUEST_METHOD'];
        $this->data = $data ?? (json_decode(file_get_contents('php://input'), true) ?? []);
        $this->token = $token ?? ($_COOKIE['jwt'] ?? '');
        $this->dataInUrl = [];
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getContent(): array
    {
        return $this->data;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getDataInUrl(): array
    {
        return $this->dataInUrl;
    }

    public function addDataInUrl($key, $value): void
    {
        $this->dataInUrl[$key] = $value;
    }

    public function mergeData(): void
    {
        foreach($this->dataInUrl as $key => $value) {
            $this->data[$key] = $value;
        }
    }
}
