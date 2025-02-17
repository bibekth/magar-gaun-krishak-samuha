<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\User;

trait ForAPISection
{
    public static function generateToken()
    {
        do {
            $token = Str::random(64); // Generate a random string
            // Check if the token already exists in the users table
            $userWithToken = User::where('token', $token)->first();
        } while ($userWithToken); // Keep generating until a unique token is found

        return $token;
    }
}
