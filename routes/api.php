<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SkillController;



//users
Route::get('/', [UserController::class, 'index']);
Route::post('/store', [UserController::class, 'store']);
Route::get('filter',[UserController::class,'filter']);
Route::get('login',[UserController::class, 'login']);

Route::get('/skills', [SkillController::class, 'get']);
//Route::post('/store', [UserController::class, 'store']);



