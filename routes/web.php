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
Route::get('/profile/my-courses/{type}', [DashboardController::class, 'index']) -> name('profile.course.index');
Route::get('/profile/course/create', [DashboardController::class, 'index']) -> name('profile.course.create');
Route::get('/profile/course/{slug}/edit', [DashboardController::class, 'index']) -> name('profile.course.edit');
Route::get('/profile/courses/{slug}', [DashboardController::class, 'index']) -> name('profile.course.show');

Route::get('/profile/courses/{slug}/lesson-create', [DashboardController::class, 'index'])
    -> name('profile.course.lesson.create');
Route::get('/profile/courses/{slug}/lesson/{lesson_slug}/edit', [DashboardController::class, 'index'])
    -> name('profile.course.lesson.edit');
Route::get('/profile/students' ,[DashboardController::class, 'index']) -> name('profile.students');
Route::get('/profile/messages' ,[DashboardController::class, 'index']) -> name('profile.messages');
Route::get('/profile/transactions' ,[DashboardController::class, 'index']) -> name('profile.transactions');
Route::get('/profile/notifications' ,[DashboardController::class, 'index']) -> name('profile.notifications');

Route::get('/profile/education' ,[DashboardController::class, 'index']) -> name('profile.education');
Route::get('/profile/teachers' ,[DashboardController::class, 'index']) -> name('profile.teachers');
Route::get('/profile/tests' ,[DashboardController::class, 'index']) -> name('profile.tests');

use App\Http\Controllers\Site\CatalogController;
Route::get('/catalog/{edu_slug}', [CatalogController::class, 'index']) -> name('catalog');
Route::get('/catalog/{edu_slug}/{slug}', [CatalogController::class, 'show']) -> name('catalog.show');

use App\Http\Controllers\Site\LessonController;
Route::get('/catalog/{edu_slug}/{course_slug}/{slug}', [LessonController::class, 'show']) -> name('lesson.show');

Route::get('/catalog/{edu_slug}/{course_slug}/{slug}/study', [LessonController::class, 'study']) -> name('lesson.study');

use App\Http\Controllers\Site\TeacherController;
Route::get('/search-teacher', [TeacherController::class, 'index']) -> name('teacher.index');
Route::get('/search-teachers/{id}', [TeacherController::class, 'show']) -> name('teacher.show');
use App\Http\Controllers\Site\OrderController;
Route::get('/order/success', [OrderController::class, 'success']) -> name('order.success');
Route::get('/order/fail', [OrderController::class, 'fail']) -> name('order.fail');

//Search
use App\Http\Controllers\Site\SearchController;
Route::get('/search', [SearchController::class, 'index']) -> name('search');

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
Route::get('/how-it-works', function(){
    return view('site.faq');
});
