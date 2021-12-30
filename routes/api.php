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
Route::post('/profile/course/update',[TeacherCourseController::class,'update'])->name('profile.course.update');
Route::get('/profile/course/{slug}/show', [TeacherCourseController::class,'show']) -> name('profile.course.show');


use App\Http\Controllers\Api\Profile\TeacherLessonController;
Route::get('/profile/{course_slug}/{slug}/show', [TeacherLessonController::class, 'show']) -> name('profile.lesson.show');
Route::post('/profile/lesson/store', [TeacherLessonController::class, 'store']) -> name('profile.lesson.store');
Route::post('/profile/lesson/update', [TeacherLessonController::class, 'update']) -> name('profile.lesson.update');

use App\Http\Controllers\Api\Profile\ProfileController;
    Route::get('/profile/account', [ProfileController::class, 'account']) ->name('profile.user.account');

//Header nav
use App\Http\Controllers\Api\HeaderNavController;
Route::get('/header-nav/edu-types', [HeaderNavController::class, 'eduTypesList']) -> name('header-nav.edu-list');
Route::get('/header-nav/edu-levels', [HeaderNavController::class, 'eduLevelsList']) -> name('header-nav.edu-levels-list');
Route::get('/header-nav/edu-subjects', [HeaderNavController::class,'eduSubjectsList']) -> name('header-nav.edu-subjects-list');
Route::post('/header-nav/filter', [HeaderNavController::class,'filter']) -> name('header-nav.filter');




