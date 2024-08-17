<?php

namespace App\DTOs\AuthDTO;

use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;

class AuthDTO
{

    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function formRegisterRequest(RegisterRequest $request)
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }
    public static function formLoginRequest(LoginRequest $request)
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }
}
