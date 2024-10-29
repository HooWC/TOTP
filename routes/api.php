<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Account\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthenticatorController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('user',UserApiController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);
Route::post('/verifyEmail', [AuthController::class, 'verifyEmail'])->name('verifyEmail.post');

Route::group(['prefix' => 'account', 'as' => 'api.account.', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'authenticator', 'as' => 'authenticator.'], function () {
        // api.account.authenticator.verify
        Route::post('verify', [AuthenticatorController::class, 'verify']);
    });

    Route::resource('authenticators', AuthenticatorController::class)->parameters([
        'authenticator' => 'authenticator'
    ])->only(['index','store','update','destroy']);

});

Route::group(['prefix' => 'ajax'], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::post('isDisabledUser', [AdminController::class, 'isDisabledUser']);
    });

    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
        Route::get('getKeyCode', [AccountController::class,'getKeyCode']);
        Route::post('getNewAuthenticator', [AccountController::class,'getNewAuthenticator']);
        Route::post('deleteAuthenticatorFunction', [AccountController::class,'deleteAuthenticatorFunction']);
        Route::post('filterProjectName', [AccountController::class,'filterProjectName']);
    });

});



