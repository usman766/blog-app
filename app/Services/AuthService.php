<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function register($data)
    {
        return User::create($data);
    }
}
