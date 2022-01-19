<?php

namespace Kobisi\CompanyService\Core;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
use Kobisi\CompanyService\Core\Core;
use Kobisi\CompanyService\Service\JWT;

class Authenticator extends Core
{
    private JWT $JWTObject;
    private ?int $companyId;
    private ?string $who = null;
    private ?array $payload = null;

    public function __construct(JWT $JWTObject)
    {
        $this->JWTObject = $JWTObject;
    }

    public function check(string $controllerName, string $actionMethod): bool
    {
        $config = $this->endpoint->getConfig();
        $content = $this->endpoint->getRequest()->getContent();

        $this->JWTObject->setSecretKey($config->getSecret());
        $payload = $this->JWTObject->payload(isset($content['token']) ? $content['token']: '');
        if($payload === null) {
            $this->companyId = null;
            $this->who = 'guest';
            $this->payload = null;
        } else {
            $this->companyId = $payload['companyId'];
            $this->who = $payload['who'];
            $this->payload = $payload;
        }
        $authorization = $config->getAuthorization();
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

    public function getJWTObject(): JWT
    {
        return $this->JWTObject;
    }

    public function setJWTObject(JWT $JWTObject): void
    {
        $this->JWTObject = $JWTObject;
    }

    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }
    
}
