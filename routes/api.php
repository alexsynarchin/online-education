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
Route::post('/profile/course/{id}/remove', [TeacherCourseController::class, 'remove']) -> name('profile.course.remove');


use App\Http\Controllers\Api\Profile\TeacherLessonController;
Route::get('/profile/{course_slug}/{slug}/show', [TeacherLessonController::class, 'show']) -> name('profile.lesson.show');
Route::post('/profile/lesson/store', [TeacherLessonController::class, 'store']) -> name('profile.lesson.store');
Route::post('/profile/lesson/update', [TeacherLessonController::class, 'update']) -> name('profile.lesson.update');
Route::post('/profile/lesson/{id}/remove', [TeacherLessonController::class,'remove']) -> name('profile.lesson.remove');

use App\Http\Controllers\Api\Profile\ProfileController;
    Route::get('/profile/account', [ProfileController::class, 'account']) ->name('profile.user.account');

//Profile user
use App\Http\Controllers\Api\Profile\UserController;
Route::get('/profile/user/show', [UserController::class, 'show']) -> name('user.show');
Route::post('/profile/user/{id}/select-profile', [UserController::class, 'selectProfile']) -> name('user.select-profile');
Route::post('/profile/user/{id}/update-email', [UserController::class, 'updateEmail']) -> name('user.update-email');
Route::post('/profile/user/{id}/update', [UserController::class, 'update']) -> name('user.update');

//Header nav
use App\Http\Controllers\Api\HeaderNavController;
Route::get('/header-nav/edu-types', [HeaderNavController::class, 'eduTypesList'])-> name('header-nav.edu-list');
Route::get('/header-nav/edu-levels', [HeaderNavController::class, 'eduLevelsList'])-> name('header-nav.edu-levels-list');
Route::get('/header-nav/edu-subjects', [HeaderNavController::class,'eduSubjectsList'])-> name('header-nav.edu-subjects-list');
Route::post('/header-nav/filter', [HeaderNavController::class,'filter']) -> name('header-nav.filter');

//Search
use App\Http\Controllers\Api\SearchController;
Route::post('/search', [SearchController::class,'search']) -> name('search');
Route::get('/search/autocomplete', [SearchController::class,'autocomplete'])->name('search.autocomplete');
Route::post('/search/autocomplete/course', [SearchController::class,'autocompleteToCourse'])
    ->name('search.autocomplete.course');

//Slider Filter
use App\Http\Controllers\Api\SliderFilterController;
Route::post('/slider/filter', [SliderFilterController::class, 'filter']) -> name('slider.filter');

//Category type

use App\Http\Controllers\Api\CategoryTypeController;
Route::get('/category-{type}/{parent_id?}', [CategoryTypeController::class, 'listByType'])
    ->name('category-type.list');


//Catalog, filters
use App\Http\Controllers\Api\CatalogController;
Route::post('/catalog/filter', [CatalogController::class, 'filter'])-> name('catalog.filter');

use App\Http\Controllers\Api\SearchTeacherController;
Route::get('/search-teacher/filter', [SearchTeacherController::class,'filter'])->name('search-teacher.filter');
Route::post('/search-teacher', [SearchTeacherController::class, 'search']) -> name('search-teacher');

//Social auth
use App\Http\Controllers\Api\Auth\SocialAuthController;

Route::get('/social-auth/{provider}', [SocialAuthController::class,'redirectToProvider'])->name('auth.social');
Route::get('/social-auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])
    ->name('auth.social.callback');

//Comments
Use App\Http\Controllers\Site\Api\CommentController;
Route::post('/comment/store', [CommentController::class, 'store']) -> name('comment.store');



