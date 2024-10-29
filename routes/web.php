<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Saml\SpLoginController;
use App\Http\Controllers\TotpController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $samlResponse = $request->input('SAMLResponse');
    if ($samlResponse) {
        $SpLoginController = new SpLoginController();
        return $SpLoginController->loginIDP($request);
    }

    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account/home', [UserController::class, 'home'])->name('account.home');
    Route::get('/account/totp', [UserController::class, 'totp'])->name('account.totp');
    Route::post('/totp/add', [TotpController::class,'addTotp'])->name('add.post');
    Route::post('/totp/edit', [TotpController::class,'editAccountName'])->name('edit.post');
});

Route::middleware(['auth:sanctum','verified', 'role:admin'])->group(function (){
    Route::get('/admin/users', [UserController::class, 'users'])->name('admin.users');
});

require __DIR__.'/auth.php';
