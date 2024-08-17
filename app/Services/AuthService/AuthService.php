<?php

namespace App\Services\AuthService;

use App\Models\User;
use Illuminate\Support\Str;
use App\DTOs\AuthDTO\AuthDTO;
use App\Events\NewUserCreated;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthService
{
    private $secretKey = "qQKPjndxljuYQi/POiXJa8O19nVO/vTf/DpXO541g=qQKPjndxljuYQi/POiXJa8O19nVO/vTf/DpXO541g=";

    public function register(AuthDTO $dto)
    {
        $user =  User::create([
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'isValidEmail' => User::IS_INVALID_EMAIL,
            'remember_token' => $this->generateRandomCode()
        ]);

        return $user;
    }

    public function login(AuthDTO $dto)
    {
        $user = User::where('email', $dto->email)->first();
        if (!is_null($user)) {
            if (intval($user->isValidEmail !== User::IS_VALID_EMAIL)) {
                NewUserCreated::dispatch($user);
                throw new CustomException('we send an email verification', 422);
            }
        }

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw new CustomException('email or password is invalid!', 422);
        }

        $token = $user->createToken($this->secretKey)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'isLoggedIn' => true,
            'message' => 'LoggedId',
            'code' => 200
        ];
    }

    public function generateRandomCode()
    {
        $code = Str::random(10) . time();
        return $code;
    }
}
