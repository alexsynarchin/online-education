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


use App\Http\Controllers\Admin\Api\CategoryTypeController;
Route::get('/category-types/{type}', [CategoryTypeController::class, 'getList']) ->name('category-type.list');
