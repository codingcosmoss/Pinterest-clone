<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

use function PHPUnit\Framework\returnSelf;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('/', [TestController::class, 'index'] );


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/logout' , [AuthController::class , 'logout']);
    Route::get('/getUser/{id}' , [AuthController::class , 'get']);
    Route::post('/changePass' , [AuthController::class , 'changePasword']);
    Route::get('/posts' ,  [PostController::class , 'index'] );
    Route::get('/posts/count' ,  [PostController::class , 'postCount']);
    Route::post('/user/post' , [PostController::class , 'store']);
    Route::get('/user/post/{id}' , [PostController::class , 'show']);
    Route::delete('/user/post/{id}' , [PostController::class , 'destroy']);
    Route::post('/user/post/update/{id}' , [PostController::class , 'update']);
    Route::get('/profile', [ProfileController::class, 'profil']);
    // Like
    Route::get('/checklike/{post_id}/{user_id}', [LikeController::class, 'checkLike']);
    Route::post('/user/post/like' , [LikeController::class , 'store']);
    Route::get('/getUserLikedPosts' , [LikeController::class , 'getUserLikedPosts']);
    Route::get('/post/like/users/{id}' , [LikeController::class , 'show']);
    Route::delete('/post/like/delete/{id}' , [LikeController::class , 'destroy']);
    // Comments
    Route::post('/post/comments/store' , [CommentController::class , 'store']);
    Route::post('/post/comments/reply' , [CommentController::class , 'storeReply']);
    // Profile
    Route::post('/user/update' , [ProfileController::class , 'update']);
    Route::get('/user/allposts' , [ProfileController::class , 'getPosts']);
    Route::get('/user/allpostcount' , [ProfileController::class , 'getPostsCount']);
    // Category
    Route::post('/category' , [CategoryController::class , 'store']);
    Route::get('/category/post/{id}' , [CategoryController::class , 'get']);
    Route::get('/category/all' , [CategoryController::class , 'getAll']);

    // Statictis
    Route::get('/statistic' , [PostController::class , 'postStatistics']);
});