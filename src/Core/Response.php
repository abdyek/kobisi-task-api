<?php

namespace Kobisi\CompanyService\Core;

use Kobisi\CompanyService\Core\Core;

class Response extends Core
{
    private int $code;
    private array $content;

    public function __construct()
    {
        $this->code = 200;
        $this->content = [];
    }

    public function serve(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($this->code);
        $responseArr = [
            'status' => 200,
            'message' => 'success',
            'content' => $this->content
        ];
        if(empty($this->content)) {
            unset($responseArr['content']);
        }
        if($this->code === 200) {
            echo json_encode($responseArr);
        }
        die();
    }

    public function notFound(): void
    {
        $this->code = 404;
        $this->serve();
    }

    public function forbidden(): void
    {
        $this->code = 403;
        $this->serve();
    }

    public function unauthorized(): void
    {
        $this->code = 401;
        $this->serve();
    }

    public function conflict(): void
    {
        $this->code = 409;
        $this->serve();
    }

    public function badRequest(): void
    {
        $this->code = 400;
        $this->serve();
    }

    public function serviceUnavailable(): void
    {
        $this->code = 503;
        $this->serve();
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): void
    {
        $this->content = $content;
    }
}
