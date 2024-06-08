<?php

declare(strict_types=1);

namespace App\Repositories\Auth;

use App\Gateways\Auth\AuthGateway;
use Illuminate\Support\Facades\Cache;

class AuthRepository implements AuthGateway
{
    private $authCacheKey = 'auth';

    public function setToken(string $email, string $token, int $expiredAt): void
    {
        $auths = Cache::get($this->authCacheKey, []);

        $auth = [
            'email' => $email,
            'token' => $token,
            'expired_at' => $expiredAt,
        ];

        $auths[] = $auth;

        Cache::put($this->authCacheKey, $auths);
    }

    public function verifyToken(string $email): bool
    {
        $auths = Cache::get($this->authCacheKey);
        
        if (!is_array($auths)) {
            return false;
        }
    
        foreach ($auths as $auth) {
            if (is_array($auth) && isset($auth['email']) && $auth['email'] === $email) {
                return true;
            }
        }
    
        return false;
    }

    public function setExpiredAt(string $email, int $newExpiredAt): void
    {
        $auths = Cache::get($this->authCacheKey, []);

        foreach ($auths as $key => $auth) {
            if ($auth['email'] = $email) {
                unset($auths[$key]);
                break;
            }
        }

        Cache::put($this->authCacheKey, $auths);
    }

    public function getExpiredAt(string $email): ?int
    {
        $auths = Cache::get($this->authCacheKey, []);

        foreach ($auths as $auth) {
            if ($auth["email"] = $email) {
                return $auth['expired_at'];
            }
        }
        
        return null;
    }
}
