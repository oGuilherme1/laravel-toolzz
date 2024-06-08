<?php

declare(strict_types=1);

namespace App\Gateways\User;

interface UserGateway
{
    public function createUser(array $data): array;
    public function getEmail(string $email, string $senha = ''): bool;
    public function getUser(): array;
}