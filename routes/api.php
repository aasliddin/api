<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BolimController;
use App\Http\Controllers\ChatsController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::prefix('/message')
    ->group(function () {
        Route::get('/', [MessageController::class,'getMessage']);
        Route::get('/{id}', [MessageController::class,'gettMessage']);
        Route::post('/create', [MessageController::class,'createMessage']);
        Route::post('/update', [MessageController::class,'updateMessage']);
        Route::post('/active', [MessageController::class,'activeMessage']);
    });
    Route::prefix('/chat')
    ->group(function () {
        Route::get('/{id}', [ChatsController::class,'getChat']);
        Route::get('/active/{id}', [ChatsController::class,'active']);
        Route::post('/create', [ChatsController::class,'createChat']);
        Route::post('/update', [ChatsController::class,'updateChat']);
    });
    
//   /*  */
});
Route::prefix('/bolim')
    ->group(function () {
        Route::get('/{id}', [BolimController::class,'getBolim']);
        Route::post('/create', [BolimController::class,'createBolim']);
        Route::post('/update', [BolimController::class,'updateBolim']);
    });
Route::any("login",[UserController::class,'index'])->name('login');;
Route::any("register",[UserController::class,'register'])->name('register');;
