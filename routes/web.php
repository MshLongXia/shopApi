<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [TestController::class, 'index']);


//登录登出
Route::prefix('auth')->group(function (){
    Route::any('login',AuthController::class.'@login');
    Route::get('loginOut',AuthController::class.'@loginOut');
    Route::get('changPwd',function (){
        return view('ChangPwd');
    });
    Route::post('changPwd',AuthController::class.'@ChangPwd');
});
