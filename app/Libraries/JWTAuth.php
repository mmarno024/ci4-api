<?php

namespace App\Libraries;

use \Firebase\JWT\JWT;

class JWTAuth
{
    protected $cache;

    public function __construct()
    {
        $this->cache = \Config\Services::cache();
    }
    private $key = "HipH1PHOORr4YY";

    public function encode($data)
    {
        return JWT::encode($data, $this->key, 'HS256');
    }

    public function decode($token)
    {
        $key = new \Firebase\JWT\Key($this->key, 'HS256');
        return JWT::decode($token, $key);
    }

    public function invalidateToken($token)
    {
        $this->cache->save('blacklisted_' . $token, true, 360);
    }

    public function isTokenBlacklisted($token)
    {
        return $this->cache->get('blacklisted_' . $token) === true;
    }
}
