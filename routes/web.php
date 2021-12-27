<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Site\HomeController;
Route::get('/', [HomeController::class, 'index']) -> name('home');

use App\Http\Controllers\Admin\Auth\LoginController as AdminLogin;
Route::get('/admin-login', [AdminLogin::class, 'login']) -> middleware('admin-guest') -> name('admin.login');
Route::post('/admin/handle-login',[AdminLogin::class, 'handleLogin']) -> name('admin.handle-login');

use App\Http\Controllers\Auth\RegisterController;
Route::post('/register', [RegisterController::class,'register'])->name('register');

use App\Http\Controllers\Auth\LoginController;
Route::post('/login', [LoginController::class,'login']) -> name('login');
Route::post('/logout', [LoginController::class, 'logout']) -> name('logout');

use App\Http\Controllers\DashboardController;
Route::get('/profile', [DashboardController::class, 'index']) -> name('dashboard');
Route::get('/profile/my-courses/{slug}', [DashboardController::class, 'index']) -> name('profile.course.index');
Route::get('/profile/course/create', [DashboardController::class, 'index']) -> name('profile.course.create');
Route::get('/profile/course/{slug}/edit', [DashboardController::class, 'index']) -> name('profile.course.edit');
Route::get('/profile/courses/{slug}', [DashboardController::class, 'index']) -> name('profile.course.show');



Route::get('/for-teachers', function(){
    return view('site.inner');
});
Route::get('/about', function(){
    return view('site.inner');
});
Route::get('/for-student', function(){
    return view('site.inner');
});
Route::get('/blog', function(){
    return view('site.inner');
});
Route::get('/faq', function(){
    return view('site.faq');
});
