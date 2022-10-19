<?php

namespace App\Http\Controllers\Api;

use App\AgentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;


class JWTAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'agentRequest', 'socialLogin']]);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function socialLogin(Request $request){

        $user = User::where('email',$request->input('data.email'))->first();
        if (!$user){
            $file_certif = uniqid() . '.' . 'png';
            $data = Image::make($request->input('data.url'));
            $data->resize(800, 800)->insert(public_path('logo.png'), 'bottom-right', 10, 10)->save(storage_path() . '/app/public/uploads/users/' . $file_certif);
            $user = User::create([
                'first_name' => $request->input('data.first_name'),
                'last_name' => $request->input('data.last_name'),
                'email' => $request->input('data.email'),
                'social_token' => $request->input('data.token'),
                'social_type' => $request->input('data.social_type'),
                'avatar' => $file_certif
            ]);
            $user->roles()->attach(5);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Successfully logged',
            'user' => $user,
            'token' => $token,
            'status' => 200
        ]);

    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        if (!($request->input('user.social_type'))) {
            $validator = Validator::make($request->user, [
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
            ],[
                'email.required'=>'email_require_error',
                'email.unique'=>'email_error',
                'email.email'=>'email_not_valid',
                'firstName.required'=>'first_name_error',
                'lastName.required'=>'last_name_error',
                'password.required'=>'password_require_error',
                'password_confirmation.required'=>'password_confirmation_require_error',
                'password.min'=>'password_min_error',
                'password.confirmed'=>'confirm_password_error',
                'password_confirmation.confirmed'=>'confirm_password_error',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages(),
                    'status' => 400
                ]);
            }
            $user = User::create([
                'first_name' => $request->input('user.firstName'),
                'last_name' => $request->input('user.lastName'),
                'email' => $request->input('user.email'),
                'password' => Hash::make($request->input('user.password')),
            ]);
            $user->roles()->attach(5);
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
                'message' => 'Successfully Registered',
                'token' => $this->createNewToken($token),
                'user' => $user,
                'status' => 201
            ]);

        } else {
            $user = User::create([
                'first_name' => $request->input('user.firstName'),
                'last_name' => $request->input('user.lastName'),
                'email' => $request->input('user.email'),
                'social_token' => $request->input('user.social_token'),
                'password' => $request->input('user.password'),
                'avatar' => $request->input('user.imageUrl'),
                'social_type' => $request->input('user.social_type'),
            ]);
            $user->roles()->attach(5);
            return response()->json([
                'message' => 'Successfully Registered',
                'token' => $user->social_token,
                'user' => $user,
                'status' => 201
            ]);
        }

    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function agentRequest(Request $request)
    {
            $validator = Validator::make($request->user, [
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'unique:users'],
            ],[
                'email.required'=>'email_require_error',
                'email.unique'=>'email_error',
                'email.email'=>'email_not_valid',
                'firstName.required'=>'first_name_error',
                'lastName.required'=>'last_name_error',
                'phone.required' => "phone_required",
                'phone.unique' => "phone_unique",
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->messages(),
                    'status' => 400
                ]);
            }

            $request = AgentRequest::create([
                'first_name' => $request->input('user.firstName'),
                'last_name' => $request->input('user.lastName'),
                'email' => $request->input('user.email'),
                'phone' => $request->input('user.phone'),
            ]);
           if ($request) {
               return response()->json([
                   'message' => 'Successfully Registered',
                   'request_status' => true,
                   'status' => 200
               ]);
           }else{
               return response()->json([
                   'message' => 'Something went wrong please try again!',
                   'status' => 'error',
               ], 200);
           }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required'=>'require',
            'email.email'=>'email_not_valid',
            'password.required'=>'require',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'status' => 400
            ]);
        }

        $email = $request->input('email');

        $user = User::query()->where('email', $email)->first();
        if(!$user){
            return response()->json([
                'errors' => ['email_or_password' => ['email_or_password_wrong']],
                'status' => 400
            ]);
        }
        $password = $request->input('password');

        if(!Hash::check($password, $user->password)){
            return response()->json([
                'errors' => ['email_or_password' => ['email_or_password_wrong']],
                'status' => 400
            ]);
        }else{
            $credentials = [
                'email' => $email,
                'password' => $password
            ];
            $token = auth('api')->attempt($credentials);

            return response()->json([
                'message' => 'Successfully logged',
                'user' => $user,
                'token' => $this->createNewToken($token),
                'status' => 200
            ]);
        }
    }

    public function getAuthenticatedUser()
    {
        if($user = auth('api')->user()){
            return response()->json(compact('user'));
        }else{
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 'error',
            ], 200);
        }
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
    protected function googleCallback(){
        return response()->json([
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
