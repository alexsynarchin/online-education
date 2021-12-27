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
use App\Http\Controllers\Api\CategoryController;
Route::get('/category/list/{type}/{parent_id?}', [CategoryController::class,'typeList']) ->name('category.type-list');

use App\Http\Controllers\Api\Profile\TeacherCourseController;
Route::get('/profile/course/index', [TeacherCourseController::class,'index']) -> name('profile.course.index');
Route::post('/profile/course/store',[TeacherCourseController::class,'store'])->name('profile.course.store');


