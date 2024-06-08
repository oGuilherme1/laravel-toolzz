<?php

declare(strict_types=1);

namespace App\Services\Auth;

use Exception;
use App\Gateways\Auth\AuthGateway;
use App\Gateways\User\UserGateway;
use Illuminate\Support\Facades\Crypt;

class GenerateTokenService {

    protected $interfaceGatewayAuth;
    protected $interfaceGatewayUser;

    private function __construct(AuthGateway $interfaceGatewayAuth, UserGateway $interfaceGatewayUser)
    {
        $this->interfaceGatewayAuth = $interfaceGatewayAuth;
        $this->interfaceGatewayUser = $interfaceGatewayUser;
    }

    public static function create(AuthGateway $interfaceGateway, UserGateway $interfaceGatewayUser): object
    {
        return new self($interfaceGateway, $interfaceGatewayUser);
    }

    public function execute(string $email, string $senha): string
    {
        try{
            $existingEmail = $this->interfaceGatewayUser->getEmail($email, $senha);

            if(!$existingEmail) {
                throw new Exception('Email or password incorrected!');
            }

            return $this->generateToken($email);
        }
        catch (Exception $e) {
            
            return $e->getMessage();
        }

    } 

    private function generateToken(string $email, int $expirationTime = 3600): string
    {
        $token = bin2hex(random_bytes(32));

        $expiration = time() + $expirationTime;

        $data = "$email.$token.$expiration";
    
        $encryptedToken = Crypt::encrypt($data);

        $this->interfaceGatewayAuth->setToken($email, $token, $expiration);

        return $encryptedToken;
    }

    public function isExpired(string $token): bool
    {
        $decryptedData = Crypt::decrypt($token);

        list($email, $myToken, $expiration) = explode('.', $decryptedData);

        $expiredAt = $this->interfaceGatewayAuth->getExpiredAt($email);

        return (int) $expiredAt < time();
    }
}