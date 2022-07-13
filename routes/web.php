<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

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

Route::prefix('test')->group(function () {
    Route::get('just_test', \App\Http\Controllers\testController_1::class.'@test');
});
//登录登出
Route::prefix('auth')->group(function (){
    Route::any('login',AuthController::class.'@login');
    Route::get('loginOut',AuthController::class.'@loginOut');
    Route::get('changPwd',function (){
        return view('ChangPwd');
    });
    Route::post('changPwd',AuthController::class.'@ChangPwd');
});

//
//Route::group([
//
//    'prefix' => 'auth'
//
//], function ($router) {
//
//    Route::get('login', 'AuthController@login');
//    Route::post('logout', 'AuthController@logout');
//    Route::post('refresh', 'AuthController@refresh');
//    Route::post('me', 'AuthController@me');
//
//});
