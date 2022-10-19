<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    use SendsPasswordResetEmails;
    use Notifiable;

    public function login(Request $request)
    {
        try {
            $email = $request->input('user.email');

            $user = User::query()->where('email', $email)->first();
            if (!$user) {
                return response(['error' => 'Email not valid'], 500);
            }
            $password = $request->input('user.password');
            $pass = Hash::make($password);

            if (Hash::check($user->password, $password)) {
                return response(['error' => 'Password not valid'], 500);
            }

            return $pass;

        } catch (\Exception $error) {
            return response($error->getMessage());
        }


    }

    public function forgotPassword(Request $request)
    {
        try {
            $email = $request->input('email');

            $user = User::query()->where('email', $email)->first();
            if (!$user) {
                return response()->json(['status' => 400, 'errors' => ['email_valid' => 'email_not_valid']]);
            }
            $token = app(PasswordBroker::class)->createToken($user);
            $user->sendPasswordResetNotification($token, $user->email);

            return response('ok', 200);

        } catch (\Exception $error) {
            return response($error->getMessage());
        }
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->user, [
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.required' => 'password_require_error',
            'password_confirmation.required' => 'password_confirmation_require_error',
            'password.min' => 'password_min_error',
            'password.confirmed' => 'confirm_password_error',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'status' => 400
            ]);
        }
        $user = User::query()->where('email', $request->input('user.email'));
        $user->update([
            'password' => Hash::make($request->input('user.password')),
        ]);
        $credentials = [
            'email' => $request->input('user.email'),
            'password' => $request->input('user.password')
        ];
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'errors' => ['error' => 'Unauthorized'],
                'status' => 400
            ]);
        }
        return response()->json([
            'message' => 'Successfully changed password',
            'token' => $this->createNewToken($token),
            'user' => $user,
            'status' => 201
        ]);
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}

