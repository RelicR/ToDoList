<?php

use App\Http\Controllers\TestController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/register', function () {
    if (Auth::check())
    {
        return redirect('profile');
    }
    else
    {
        return view('register');
    }
});

Route::post('/register', [TestController::class, 'register']);
Route::get('/login', function () {
    Auth::logout();
    return view('login');
})->name('login');
Route::post('/login', [TestController::class, 'login']);
Route::get('/profile', function () {
    return view('profile');
})->middleware(Authenticate::class);
Route::post('/profile', [TestController::class, 'newTask'])->middleware(Authenticate::class);
Route::post('/handleTasks', [TestController::class, 'handleTasks'])->middleware(Authenticate::class);
Route::get('/logout', [TestController::class, 'logout']);