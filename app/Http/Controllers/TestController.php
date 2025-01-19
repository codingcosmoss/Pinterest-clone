<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::first();

        return response()->json([
            'name' => 'Alisher'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->password = $request->password;
            $newUser->email = $request->email;


            if ($newUser->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Created !',
                    'data' => $newUser
                ]);
            }


        } catch (Exception $e) {

            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null
            ]);

        }
    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

  
    /**
     * Update the specified resource in storage.
     */
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
