<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
// use Auth;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Validator;
class AuthController extends Controller
{
    
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function register(Request $request)
    {
        # code...

        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:50',
            'bod' => 'required|string|max:10',
            'email' => 'required|string|email|max:255|unique:user_profiles',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password)
         ]);
        $profile = UserProfile::create([
            'username' => $request->username,
            'name' => $request->name,
            'address' => $request->address,
            'bod' => $request->bod,
            'email' => $request->email,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);

    }
    public function login(Request $request)
    {
        // if (!Auth::attempt($request->only('username', 'password')))
        // {
        //     return response()
        //         ->json(['message' => 'Unauthorized'], 401);
        // }

        // $user = User::where('username', $request['username'])->firstOrFail();

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()
        //     ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);



        // $credentials = $request->only('username', 'password');

        // if ($token = $this->Auth::guard('jwt')->attempt($credentials)) {
        //     return $this->respondWithToken($token);
        // }

        // return response()->json(['error' => 'Unauthorized'], 401);

        $input = $request->only('username', 'password');
        $jwt_token = null;
  
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Username or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }
  
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
    public function update(Request $request)
    {
        $input = $request->all();
        // dd($request->all());
        $username = Auth::guard('sanctum')->user()->username;
        // dd($username);
        try {
            //code...
            $profile = UserProfile::where('username', $username)->firstOrFail();
        } catch (\Exception $e) {
            return response()
                ->json(['message' => 'User Not Found'], 404);
        }


        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:50',
            'bod' => 'required|string|max:10',
            'email' => 'unique:user_profiles,email,'.$profile->id
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        UserProfile::where('username', $username)->update(
            [
                'name' => $request->name,
                'address' => $request->address,
                'bod' => $request->bod,
                'email' => $request->email,
            ]
        );
        return [
            'message' => 'Profile was update'
        ];
    }
    
    public function profile(Request $request)
    {
        # code...
        $username = Auth::guard('sanctum')->user()->username;
        $userProfile = UserProfile::where('username', $username)->firstOrFail();
        return response()->json($userProfile);
        // return auth()->user();
    }

}
