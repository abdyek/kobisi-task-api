<?php

namespace Kobisi\CompanyService\Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Kobisi\CompanyService\Core\Core;

class Authenticator extends Core
{
    private ?int $userId;
    private ?string $who = null;
    private ?array $payload;

    public function check(string $controllerName, string $actionMethod): bool
    {
        $this->solveJWT();
        $authorization = $this->endpoint->getConfig()->getAuthorization();
        $authorizationKeys = array_keys($authorization);
        if(!in_array($controllerName, $authorizationKeys)) {
            return true;
        }
        $functions = array_keys($authorization[$controllerName]);
        if(!in_array($actionMethod, $functions)) {
            return true;
        }
        if(in_array($this->who, $authorization[$controllerName][$actionMethod])) {
            return true;
        }
        return false;
    }

    private function solveJWT(): void
    {
        $token = $this->endpoint->getRequest()->getToken();
        $secret = $this->endpoint->getConfig()->getSecret();
        try {
            $this->payload = (array) JWT::decode($token, new Key($secret, 'HS256'));
            $this->userId = $this->payload['userId'];
            $this->who = $this->payload['who'];
        } catch(\UnexpectedValueException $e) {
            $this->userId = null;
            $this->who = 'guest';
            $this->payload = null;
        }
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }
    
}
