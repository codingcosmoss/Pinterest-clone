<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// Route::middleware(['auth:sanctum'])->group(function () {

//     Route::get('/dashboard', function(){
//         return 'Oke';
//     });

// });
