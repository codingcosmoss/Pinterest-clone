<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profil(){

        try {

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Tasdiqlanmadi',
                'data' => new ProfileResource(auth()->user()) ,
                
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null,
            ]);
        }

    }



}
