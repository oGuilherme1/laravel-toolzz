<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Gateways\User\UserGateway;
use Illuminate\Support\Facades\Cache;

class UserRepository implements UserGateway {

    private $cacheKey = 'users';

    public function createUser(array $data): array
    {

        $users = Cache::get($this->cacheKey, []);

        $user = [
            'id' => uniqid(),
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        $users[] = $user;

        Cache::put($this->cacheKey, $users);

        return $user;

    }

    public function getUser(): array{
        return Cache::get($this->cacheKey, []);
    }

    public function getEmail(string $email, string $senha = ''): bool
    {
        $users = Cache::get($this->cacheKey, []);

        foreach ($users as $user) {
            if ($user['email'] === $email && $user['password'] === $senha) {
                return true;
            }
            if ($user['email'] === $email) {
                return true;
            }

        }

        return false;
    }

}