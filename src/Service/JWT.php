<?php

namespace Kobisi\CompanyService\Service;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;

class JWT
{
    private string $secretKey = 's3cr3t';
    private string $algorithm = 'HS256';
    private array $claims = [];

    public function generateToken(): string
    {
        return FirebaseJWT::encode($this->claims, $this->secretKey, $this->algorithm);
    }

    public function payload(string $jwt): ?array
    {
        try {
            $payload = FirebaseJWT::decode($jwt, new Key($this->secretKey, $this->algorithm));
        } catch (\UnexpectedValueException $e) {
            return null;
        }
        return self::objectToArray($payload);
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    public function setAlgorithm(string $algorithm): void
    {
        $this->algorithm = $algorithm;
    }

    public function getClaims(): array
    {
        return $this->claims;
    }

    public function setClaims(array $claims): void
    {
        $this->claims = $claims;
    }

    private static function objectToArray($object)
    {
        if(is_object($object) or is_array($object)) {
            $array = (array) $object;
            foreach($array as &$item) {
                $item = self::objectToArray($item);
            }
            return $array;
        }
        return $object;
    }

}
