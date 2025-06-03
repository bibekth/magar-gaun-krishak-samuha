<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login',[APIController::class,'login'])->name('login');
Route::middleware('token.api')->group(function (){
    Route::get('/main',[APIController::class,'main'])->name('main');
    Route::post('/pay', [APIController::class,'pay'])->name('pay');
});
