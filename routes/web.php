<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\regiscontroller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [loginController::class, 'login'])->name('login');





Route::get('/register', function () {
    return view('Rgister');
})->name('register');

Route::post('/register', [regiscontroller::class, 'create']);

Route::get('/dashboard',function(){
    return view('Dashboad');
})->middleware('auth')->name('dashboard');

Route::match(['get', 'post'], '/logout', [loginController::class, 'logout'])->name('logout');