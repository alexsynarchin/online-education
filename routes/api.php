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
//Profile
use App\Http\Controllers\Api\Profile\TeacherCourseController;
Route::get('/profile/course/index/{type}', [TeacherCourseController::class,'index']) -> name('profile.course.index');
Route::post('/profile/course/store',[TeacherCourseController::class,'store'])->name('profile.course.store');

use App\Http\Controllers\Api\Profile\ProfileController;
    Route::get('/profile/account', [ProfileController::class, 'account']) ->name('profile.user.account');

//Header nav
use App\Http\Controllers\Api\HeaderNavController;
Route::get('/header-nav/edu-types', [HeaderNavController::class, 'eduTypesList']) -> name('header-nav.edu-list');
Route::get('/header-nav/edu-levels', [HeaderNavController::class, 'eduLevelsList']) -> name('header-nav.edu-levels-list');
Route::get('/header-nav/edu-subjects', [HeaderNavController::class,'eduSubjectsList']) -> name('header-nav.edu-subjects-list');
//Route::post('/header-nav/filter', 'Api\HeaderNavController@filter') -> name('header-nav.filter');




