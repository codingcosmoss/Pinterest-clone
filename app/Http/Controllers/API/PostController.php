<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    try {
        $perPage = $request->query('per_page', 10); // default 10 ta
        $posts = Post::paginate($perPage);

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Postlar ro‘yxati ⚡',
            'data' => PostResource::collection($posts),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'code' => $e->getCode() ?: 500,
            'message' => $e->getMessage(),
            'data' => null,
        ]);
    }
}


    public function postCount()
    {
        try {
        $posts = Post::where('user_id', auth()->user()->id)->get();
        $postCount = $posts->count();
        
        
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Barcha post sonlari ⚡',
                    'posts_count' => $postCount
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
{
    try {
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->title = $request->title;
        $post->description = $request->description;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); 
            $post->image = $path;
        }  

        $post->status = 0;
        $post->save();  

        // Agar `categories` maydoni JSON string sifatida kelmasa, uni array sifatida ishlatamiz
        // $categories = is_string($request->categories) ? json_decode($request->categories, true) : $request->categories;

        // Postni kategoriyalar bilan bog‘lash
        $post->categories()->attach(json_decode($request->categories , true));

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Post success created ⚡',
            'data' => new PostResource($post),
            'categories' => $request->categories
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $post = Post::with(['categories', 'comments.user', 'comments.replies.user'])->findOrFail($id);
            // $post = Post::where('id', $id)->first();
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Sizning post malumotlaringiz ⚡',
                    'data' => new PostResource($post),
                    'categories' => $post->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'posts' => $category->posts, // Ushbu kategoriya ichidagi postlar
                ];
            }),
            'comments' => $post->comments,
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $post = Post::where('id', $id)->first();
                // $post->user_id = auth()->user()->id;
                $post->title = $request->title;
                $post->description = $request->description;
                if ($request->hasFile('image')) {
                    $path = $request->file('image')->store('images', 'public'); // Rasm 'storage/app/public/images' ichiga saqlanadi
                    $post->image = $path;
                } 
                // $post->status = 0;
                $post->save();        

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Post success updated ⚡',
                    'data' => $post,
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

    public function postStatistics(Request $request) {
        try {
            $postCount = Post::count();
            $userCount = User::count();
            // $likeCount == Like::count();
            $mostFrequentUserId = Post::select('user_id')
    ->groupBy('user_id')
    ->orderByRaw('COUNT(*) DESC')
    ->limit(1)
    ->value('user_id');

            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'Post Statistics',
                'posts_count' => $postCount,
                'userCount' => $userCount,
                // 'like_count' => $likeCount,
                'topUserId' => $mostFrequentUserId
            ]);
        }

        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null,
            ]);   
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $post = Post::where('id', $id)->first();
            $post->status = 1;
            $post->save();

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Post ochirildi ⚡',
                    'data' => $post,
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
