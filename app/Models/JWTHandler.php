<?php

namespace App\Models;

class JWTHandler
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }
 
    //obtient toutes les en-têtes de la requête
    public function getAuthorizationHeader()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            return trim($headers['Authorization']);
        }
        return null;
    }

    public function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            // Rcher une chaîne qui commence par "Bearer" suppr les espaces puis prd le token 
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function decodeJWT($jwt)
    {
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) !== 3) {
            return null;
        }

        $header = json_decode(base64_decode($tokenParts[0]), true);
        $payload = json_decode(base64_decode($tokenParts[1]), true);
        $signatureProvided = $tokenParts[2];

        $base64UrlHeader = $tokenParts[0];
        $base64UrlPayload = $tokenParts[1];
        $signature = base64_decode(strtr($signatureProvided, '-_', '+/'));

        $validSignature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secretKey, true);

        if (!hash_equals($signature, $validSignature)) {
            return null;
        }

        if ($payload['exp'] < time()) {
            return null;
        }

        return $payload;
    }
}
