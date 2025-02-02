<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;



class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $like = new Like();
            $like->like_user_id  = auth()->user()->id;
            $like->post_id  = $request->post_id;
            $like->save();        

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Like bosildi ⚡',
                    'data' => 'test',
                ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => 'catch',
                'data' => null,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $likeUserIds = Like::where('post_id', $id)
                ->pluck('like_user_id'); 
                $users = User::whereIn('id', $likeUserIds)->get();

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Like data ⚡',
                    'data' => $users,
                ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => 'catch',
                'data' => null,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                       try {
                        $deleted = Like::where('like_user_id', auth()->user()->id)
                        ->where('post_id', $id)
                        ->delete();

            
                            return response()->json([
                                'status' => true,
                                'code' => 200,
                                'message' => 'Like unliked ⚡',
                                'data' => 'Deleted',
                            ]);
                        
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'code' => $e->getCode(),
                            'message' => 'catch',
                            'data' => null,
                        ]);
                    }
    }
}
