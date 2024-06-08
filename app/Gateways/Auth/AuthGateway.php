<?php

declare(strict_types=1);

namespace App\Gateways\Auth;

interface AuthGateway
{
    public function setToken(string $email, string $token, int $expiredAt): void;
    public function setExpiredAt(string $email, int $newExpiredAt): void;
    public function getExpiredAt(string $email): ?int;
    public function verifyToken(string $email): bool;
}