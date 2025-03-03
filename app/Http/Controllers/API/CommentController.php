<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    

    // 2. Yangi comment qo'shish
    public function store(Request $request)
    {
        try {
            $comment = new Comment();
                $comment->user_id = auth()->user()->id;
                $comment->post_id = $request->post_id;
                $comment->text = $request->text;
                $comment->save();

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Comment success created ⚡',
                    'data' => $comment,
                ]);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null,
            ]);
        }

    }

    public function storeReply(Request $request)
    {
        try {
            $comment = new Comment();
                $comment->user_id = auth()->user()->id;
                $comment->post_id = $request->post_id;
                $comment->text = $request->text;
                $comment->parent_id = $request->parent_id;
                $comment->save();

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Reply Comment success created ⚡',
                    'data' => $comment,
                ]);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'data' => null,
            ]);
        }

    }

    public function getComments($postId)
{
    $comments = Comment::where('post_id', $postId)
                        ->whereNull('parent_id')
                        ->with('replies')
                        ->get();

    return response()->json([
        'status' => true,
        'code' => 200,
        'data' => $comments,
    ]);
}


}
