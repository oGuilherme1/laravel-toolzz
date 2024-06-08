<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Gateways\Auth\AuthGateway;
use Illuminate\Support\Facades\Crypt;

class LogoutService {

    protected $interfaceGateway;

    private function __construct(AuthGateway $interfaceGateway)
    {
        $this->interfaceGateway = $interfaceGateway;
    }

    public static function create(AuthGateway $interfaceGateway): object
    {
        return new self($interfaceGateway);
    }

    public function execute(string $token): void
    {   
        $decryptedData = Crypt::decrypt($token);

        list($email, $myToken, $expiration) = explode('.', $decryptedData);
        
        $this->interfaceGateway->setExpiredAt($email, time());
    } 
}