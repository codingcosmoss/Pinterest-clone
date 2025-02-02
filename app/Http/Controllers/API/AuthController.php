<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;  
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function register(RegisterRequest $request) {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->login = $request->login;
            $user->password = $request->password;
            $user->save();

            $user->token = $user->createToken('laravel-vue-admin')->plainTextToken;
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Oke',
                'data' => $user,
                'token' => $user->token,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 403,
                'message' => 'Not found or forbidden',
                'data' => null,
            ]);
        }
    }

    public function login(LoginRequest $request) {
        $user = User::where('login' , $request->input('login'))->first();

        if(!$user) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Topilmadi',
                'data' => 'User topilmasa demak data xam bolmaydi 😁',
                
            ]);
        }

        if(empty($user) || !Hash::check($request->password , $user->password)) {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'Tasdiqlanmadi',
                'data' => 'Tasdiqlanmasa demak data xam bolmaydi 😁',
                
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


    public function get($id) {
        try {
            $user = User::find($id);

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Oke',
                'data' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 403,
                'message' => 'Not found or forbidden',
                'data' => null,
            ]);
        }
    }

    
    public function logout() {
        try {

            auth()->user()->currentAccessToken()->delete(); 

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Oke',
                'data' => 'Logoutga data keremasku 😶',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 403,
                'message' => 'Not found or forbidden',
                'data' => null,
            ]);
        }
    }
    
    public function changePasword(ChangePasswordRequest $request)
    {
        try {
            if (Hash::check($request->input('new-password'), auth()->user()->password)) {
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Yangi parol eski parol bilan bir xil bo\'lmasligi kerak or eski parol notogri',
                    'data' => null,
                ]);
            }
            if (Hash::check($request->input('old-password'), auth()->user()->password)) {
                auth()->user()->password = Hash::make($request->input('new-password'));
                
                auth()->user()->save();

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Parol muvaffaqiyatli ozgardi',
                    'data' => null,
                ]);
            }

            
        
                return response()->json([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Eski parol noto\'g\'ri',
                    'data' => null,
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => 500,
                'message' => 'Server xatosi',
                'data' => null,
            ]);
        }
    }
    

    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}