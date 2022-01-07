<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Admin\Auth\LoginController;
Route::post('/logout',[LoginController::class, 'logout']) -> name('logout');

use App\Http\Controllers\Admin\Api\CourseController;
Route::get('/courses', [CourseController::class, 'index']) -> name('course.index');
Route::get('/courses/{id}', [CourseController::class, 'show']) -> name('course.show');
Route::post('/course/{id}/cansel-msg', [CourseController::class,'canselMsg']) -> name('course.cansel-msg');
Route::post('/course/change-status', [CourseController::class, 'changeStatus']) -> name('course.change-status');

use App\Http\Controllers\Admin\Api\LessonController;
Route::get('/lesson/show/{id}', [LessonController::class, 'show']) -> name('lesson.show');
Route::post('/lesson/change-status', [LessonController::class, 'changeStatus']) -> name('lesson.change-status');
Route::post('/lesson/{id}/cansel-msg', [LessonController::class, 'canselMsg'])-> name('lesson.cansel-msg');

use App\Http\Controllers\Admin\Api\CategoryTypeController;
Route::get('/category-types/{type}', [CategoryTypeController::class, 'getList']) ->name('category-type.list');
Route::get('/category-types/theme/list', [CategoryTypeController::class, 'getThemes']) ->name('category-type.theme-list');
Route::get('/category-types/{type}/{id}', [CategoryTypeController::class, 'show']) -> name('category-type.show');
Route::post('/category-type/store', [CategoryTypeController::class, 'store']) -> name('category-type.store');
Route::post('/category-type/update', [CategoryTypeController::class, 'update']) -> name('category-type.update');
Route::post('/category-type/{id}/remove', [CategoryTypeController::class, 'remove']) -> name('category-type.remove');

use App\Http\Controllers\Admin\Api\UserController;
Route::get('/users', [UserController::class, 'index']) -> name('users.index');

