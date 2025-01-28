<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UsuariosController::class , 'index'])->name('index');
