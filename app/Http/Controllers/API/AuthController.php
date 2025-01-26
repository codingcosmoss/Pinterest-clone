<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function login(LoginRequest $loginRequest){

        $user = User::where('login', $loginRequest->input('login'))->first();

        if (!$user){
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Topilmadi',
                'data' => null
            ]);
        }

        if (empty($user) || !Hash::check( $loginRequest->password , $user->password)) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Tasdiqlanmadi',
                'data' => null
            ]);
        }

        $user->token = $user->createToken('laravel-vue-admin')->plainTextToken;

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Oke',
            'data' => $user,
        ]);

    }
    
    public function register(RegisterRequest $request){

        try {

            $user = new User();
            $user->name = $request->name;
            $user->login = $request->login;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->token = $user->createToken('laravel-vue-admin')->plainTextToken;
            
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Oke',
                'data' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }

    }

    public function getUser($id){

        try {
            
            $user = User::find($id);

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Oke',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }

    }

    
    public function logout(){

        try {

            auth()->user()->currentAccessToken()->delete();
            
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Oke',
                'data' => null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }

    }

}
