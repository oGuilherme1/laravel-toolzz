<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Gateways\User\UserGateway;
use Exception;

class CreateUserService {
    protected $interfaceGateway;

    private function __construct(UserGateway $interfaceGateway)
    {
        $this->interfaceGateway = $interfaceGateway;
    }

    public static function create(UserGateway $interfaceGateway): object
    {
        return new self($interfaceGateway);
    }

    public function execute(array $data): mixed
    {
        try {
            $existingEmail = $this->interfaceGateway->getEmail($data['email']);

            if($existingEmail) {
                throw new Exception('Email existing!');
            }

            $output = $this->interfaceGateway->createUser($data);
            return $output;

        } catch (Exception $e) {
            
            return $e->getMessage();
        }

    }   

}