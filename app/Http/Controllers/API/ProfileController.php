<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;


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

    public function update(Request $request){

        try {

            $user = User::where('login' , auth()->user()->login)->first();

        


        $user->name = $request->name;
        $user->login = $request->login;
        if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public'); // Rasm 'storage/app/public/images' ichiga saqlanadi
                $user->image = $path;
            }            
        $user->save();
        $changedData = User::where('login' , $request->login)->first();

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Malumotlar ozgartirildi',
                'data' => new ProfileResource($changedData), 
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

    public function getPosts(Request $request) {
        try {
            $posts = Post::where('user_id', auth()->id())->get();
    
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'User postlari',
                // PostResource::collection($posts)
                'data' => $posts, // Collection qilib qaytarish
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
    

    public function getPostsCount(Request $request) {
        try {
            $posts = Post::where('user_id', auth()->id())->get();
            $postCount = $posts->count();
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'User postlari',
                // PostResource::collection($posts)
                'count' => $postCount, // Collection qilib qaytarish
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
