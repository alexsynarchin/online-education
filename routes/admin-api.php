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
Route::post('/course/{id}/cancel-message', [CourseController::class,'canselMsg']) -> name('course.cansel-msg');
Route::post('/course/change-status', [CourseController::class, 'changeStatus']) -> name('course.change-status');
Route::post('/course/{id}/send-message', [CourseController::class, 'sendMsg']) -> name('course.sendMsg');
Route::post('/course/{id}/read-message', [CourseController::class, 'readMsg'])->name('course.readMsg');
use App\Http\Controllers\Admin\Api\LessonController;
Route::get('/lesson/show/{id}', [LessonController::class, 'show']) -> name('lesson.show');
Route::post('/lesson/change-status', [LessonController::class, 'changeStatus']) -> name('lesson.change-status');
Route::post('/lesson/{id}/cancel-message', [LessonController::class, 'canselMsg'])-> name('lesson.cansel-msg');
Route::post('/lesson/{id}/send-message', [LessonController::class, 'sendMsg']) -> name('lesson.sendMsg');
use App\Http\Controllers\Admin\Api\CategoryTypeController;
Route::get('/category-types/{type}', [CategoryTypeController::class, 'getList']) ->name('category-type.list');
Route::get('/category-types/theme/list', [CategoryTypeController::class, 'getThemes']) ->name('category-type.theme-list');
Route::get('/category-types/{type}/{id}', [CategoryTypeController::class, 'show']) -> name('category-type.show');
Route::post('/category-type/store', [CategoryTypeController::class, 'store']) -> name('category-type.store');
Route::post('/category-type/update', [CategoryTypeController::class, 'update']) -> name('category-type.update');
Route::post('/category-type/{id}/remove', [CategoryTypeController::class, 'remove']) -> name('category-type.remove');

use App\Http\Controllers\Admin\Api\UserController;
Route::get('/users', [UserController::class, 'index']) -> name('users.index');

use App\Http\Controllers\Admin\Api\PromoCodeController;
Route::post('/promo-code/store', [PromoCodeController::class, 'store'])->name('promo-code.store');
Route::get('/promo-code/list', [PromoCodeController::class, 'getList'])->name('promo-code.list');

use App\Http\Controllers\Admin\Api\SettingController;
Route::get('/setting/common/get', [SettingController::class, 'getCommon'])->name('setting.get-common');
Route::post('/setting/common-update', [SettingController::class, 'updateCommon'])->name('setting.update-common');

use App\Http\Controllers\Admin\Api\MenuController;
Route::post('/menu/store',[MenuController::class, 'store'])->name('menu.store');
Route::post('/menu/{id}/update', [MenuController::class, 'update'])->name('menu.update');
Route::post('/menu/{id}/remove',[MenuController::class, 'remove'])->name('menu.remove');
Route::get('/menu/get/{position}',[MenuController::class, 'list'])->name('menu.list');

use App\Http\Controllers\Admin\Api\StaticPageController;
Route::get('/static-pages', [StaticPageController::class, 'index'])->name('static-pages');
Route::post('/static-page/store', [StaticPageController::class,'store'])->name('static-page.store');
Route::post('/static-page/{id}/remove',[StaticPageController::class, 'remove']) -> name('page.remove');
Route::post('/static-page/{id}/update', [StaticPageController::class, 'update']) -> name('page.update');
Route::get('/static-page/{id}', [StaticPageController::class, 'item']) -> name('page.item');

use App\Http\Controllers\Admin\Api\ArticleController;
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::post('/article/store', [ArticleController::class,'store'])->name('article.store');
Route::post('/article/{id}/remove',[ArticleController::class, 'remove']) -> name('article.remove');
Route::post('/article/{id}/update', [ArticleController::class, 'update']) -> name('article.update');
Route::get('/article/{id}', [ArticleController::class, 'item']) -> name('article.item');

use App\Http\Controllers\Admin\Api\MainPageController;
Route::get('/main-page/data', [MainPageController::class, 'getData'])->name('main-page.data');
Route::post('/main-page/store', [MainPageController::class, 'store'])->name('main-page.store');

use App\Http\Controllers\Admin\Api\WithdrawController;
Route::get('/withdraws', [WithdrawController::class, 'index'])->name('withdraw.index');
Route::post('/withdraw/done', [WithdrawController::class, 'done'])->name('withdraw.done');

use App\Http\Controllers\Admin\Api\CityController;
Route::get('/cities', [CityController::class, 'index'])->name('cities');
Route::get('/city/{id}/show', [CityController::class, 'show'])->name('city.show');
Route::post('/city/store', [CityController::class, 'store'])->name('city.store');
Route::post('/city/{id}/update', [CityController::class, 'update'])->name('city.update');

use App\Http\Controllers\Admin\Api\RegionController;
Route::get('/regions', [RegionController::class, 'index'])->name('regions');
Route::get('/region/{id}/show', [RegionController::class, 'show'])->name('region.show');
Route::post('/region/store', [RegionController::class, 'store'])->name('region.store');
Route::post('/region/{id}/update', [RegionController::class, 'update'])->name('region.update');
