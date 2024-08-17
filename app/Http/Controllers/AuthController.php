<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DTOs\AuthDTO\AuthDTO;
use App\Events\NewUserCreated;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AuthResourses;
use App\Services\AuthService\AuthService;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;

class AuthController extends Controller
{
    // private $secretKey = "qQKPjndxljuYQi/POiXJa8O19nVO/vTf/DpXO541g=qQKPjndxljuYQi/POiXJa8O19nVO/vTf/DpXO541g=";

    public function __construct(
        protected AuthService $authService
    ) {
    }

    // public function register(Request $request)
    // {
    //     $data = $request->all();

    //     $errors = Validator::make($data, [
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|max:15'
    //     ]);

    //     if ($errors->fails()) {
    //         return response($errors->errors()->all(), 422);
    //     }

    //     $user = User::create([
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'isValidEmail' => User::IS_INVALID_EMAIL,
    //         'remember_token' => $this->generateRandomCode()
    //     ]);
    //     NewUserCreated::dispatch($user);
    //     return response([
    //         'message' => 'User Created'
    //     ], 200);
    // }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register(AuthDTO::formRegisterRequest($request));

        NewUserCreated::dispatch($user);
        return response([
            'message' => 'User Created'
        ], 200);
    }

    // public function login(Request $request)
    // {


    //     $data = $request->all();

    //     $errors = Validator::make($data, [
    //         'email' => 'required|email',
    //         'password' => 'required|min:6|max:15'
    //     ]);

    //     if ($errors->fails()) {
    //         return response($errors->errors()->all(), 422);
    //     }

    //     $user = User::where('email', $data['email'])->first();
    //     if (!is_null($user)) {
    //         if (intval($user->isValidEmail) == User::IS_INVALID_EMAIL) {
    //             // NewUserCreated::dispatch($user);
    //             return response([
    //                 'message' => 'We send you an email verification!',
    //                 'isLoggedIn' => false
    //             ], 422);
    //         }
    //     }

    //     if (!$user || !Hash::check($data['password'], $user['password'])) {
    //         return response([
    //             'message' => 'email or password invalid!',
    //             'isLoggedIn' => false
    //         ], 422);
    //     }

    //     $token = $user->createToken($this->secretKey)->plainTextToken;

    //     return response([
    //         'user' => $user,
    //         'message' => 'LoggedIn',
    //         'token' => $token,
    //         'isLoggedIn' => true
    //     ], 200);
    // }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(AuthDTO::formLoginRequest($request));

        return (new AuthResourses($result))
            ->response()
            ->setStatusCode(200);
    }

    public function logout(Request $request)
    {
        DB::table('personal_access_tokens')->where('tokenable_id', $request->userId)->delete();

        return response(['message' => 'User logout'], 200);
    }


    public function validEmail($token)
    {
        User::where('remember_token', $token)->update([
            'isValidEmail' => User::IS_VALID_EMAIL
        ]);

        return redirect('/app/login');
    }
    // public function generateRandomCode()
    // {
    //     $code = Str::random(10) . time();
    //     return $code;
    // }
}
