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
Route::get('/profile/course/count', [TeacherCourseController::class, 'getCoursesCount']) -> name('profile.course.count');


use App\Http\Controllers\Api\Profile\TeacherController;
Route::get('/profile/teachers', [TeacherController::class, 'index'])->name('teacher.index');


use App\Http\Controllers\Api\Profile\TeacherLessonController;
Route::get('/profile/{course_slug}/{slug}/show', [TeacherLessonController::class, 'show']) -> name('profile.lesson.show');
Route::post('/profile/lesson/store', [TeacherLessonController::class, 'store']) -> name('profile.lesson.store');
Route::post('/profile/lesson/update', [TeacherLessonController::class, 'update']) -> name('profile.lesson.update');
Route::post('/profile/lesson/{id}/remove', [TeacherLessonController::class,'remove']) -> name('profile.lesson.remove');

use App\Http\Controllers\Api\Profile\ProfileController;
    Route::get('/profile/account', [ProfileController::class, 'account']) ->name('profile.user.account');
    Route::get('/sidebar-balance', [ProfileController::class, 'sidebarBalance'])->name('profile.sidebar-balance');
//Profile user
use App\Http\Controllers\Api\Profile\UserController;
Route::get('/profile/user/show', [UserController::class, 'show']) -> name('user.show');
Route::post('/profile/user/{id}/select-profile', [UserController::class, 'selectProfile']) -> name('user.select-profile');
Route::post('/profile/user/{id}/update-email', [UserController::class, 'updateEmail']) -> name('user.update-email');
Route::post('/profile/user/{id}/update', [UserController::class, 'update']) -> name('user.update');
Route::post('/profile/user/phone-confirmation', [UserController::class, 'phoneConfirmation']) -> name('user.phone-confirmation');
Route::post('/profile/user/phone-check-code', [UserController::class, 'checkPhoneCode'])->name('user.check.phone-code');
Route::post('/profile/user/email/verification-notification', [UserController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//Header nav
use App\Http\Controllers\Api\HeaderNavController;
Route::get('/header-nav/edu-types', [HeaderNavController::class, 'eduTypesList'])-> name('header-nav.edu-list');
Route::get('/header-nav/edu-levels', [HeaderNavController::class, 'eduLevelsList'])-> name('header-nav.edu-levels-list');
Route::get('/header-nav/edu-subjects', [HeaderNavController::class,'eduSubjectsList'])-> name('header-nav.edu-subjects-list');
Route::get('/header-nav/directions', [HeaderNavController::class, 'getDirections']) -> name('header-nav.get-directions');
Route::post('/header-nav/direction/redirect', [HeaderNavController::class,'redirectDirectionPage']) -> name('header-nav.redirect-direction-page');
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
Route::get('/comments/course/{id}', [CommentController::class, 'index']) -> name('comment.index');

//Promo Codes
use App\Http\Controllers\Api\Profile\PromoCodeController;
Route::post('/promo-code/handle', [PromoCodeController::class,'handlePromoCode'])->name('promo-code.handle');


//Buying
use App\Http\Controllers\Api\BuyingController;
Route::get('/buying/data', [BuyingController::class, 'getData'])->name('buying.data');
Route::post('/buying/buy', [BuyingController::class,'buy'])->name('buying.buy');
Route::post('/buying/handle-discount', [BuyingController::class, 'handleDiscount'])->name('buying.handle-discount');
//Payment

//Student Courses
use App\Http\Controllers\Api\Profile\StudentCourseController;
Route::get('/education', [StudentCourseController::class,'index'])->name('student-course.index');
// Student Test Controller
use App\Http\Controllers\Api\Profile\StudentTestController;
Route::get('/education/test/{id}', [StudentTestController::class, 'index'])->name('student-test.index');
Route::get('/education/test/{id}/result', [StudentTestController::class, 'result'])->name('student-test.result');
Route::post('/education/test/{id}/pass', [StudentTestController::class, 'pass'])->name('test-student.pass');


// Chat controller
use App\Http\Controllers\Api\Profile\ChatController;
Route::get('/profile/chats',[ChatController::class, 'index']) ->name('chat.index');
Route::post('/profile/chats/createOrGo', [ChatController::class, 'createOrGo']) -> name('chat.create-or-go');
Route::get('/profile/chats/{id}',[ChatController::class, 'show'])->name('chat.show');
Route::post('/profile/chats/{id}/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');
Route::get('/profile/chats/{id}/messages', [ChatController::class, 'messages'])->name('chat.messages');

use App\Http\Controllers\Api\Profile\StudentLessonController;


use App\Http\Controllers\Api\Profile\NotificationController;
Route::get('/profile/notifications', [NotificationController::class, 'index'])->name('profile.notifications');
Route::get('/profile/notifications/unread', [NotificationController::class, 'unread'])->name('profile.notifications.unread');
Route::post('/profile/notifications/read',  [NotificationController::class,'read'])->name('profile.notifications.read');


use App\Http\Controllers\Api\Profile\TestResultController;
Route::get('/profile/tests', [TestResultController::class, 'index'])->name('profile.test.index');

use App\Http\Controllers\Api\Profile\TeacherStudentController;
Route::get('/profile/my-students', [TeacherStudentController::class, 'index'])->name('profile.my-students.index');
use App\Http\Controllers\Api\Profile\WithdrawController;
Route::post('/profile/withdraw', [WithdrawController::class, 'withdraw']) ->name('profile.withdraw');
Route::get('/profile/withdraw/list', [WithdrawController::class, 'list'])->name('profile.withdraw.list');

use App\Http\Controllers\Api\OrderController;
Route::get('/profile/orders', [OrderController::class, 'index'])->name('order.index');

use App\Http\Controllers\Api\ContactController;
Route::post('/contact', [ContactController::class, 'contact'])->name('contact');

use App\Http\Controllers\Api\Profile\EduChatController;
Route::get('/profile/edu-chat/{id}/messages',[EduChatController::class, 'index'])->name('eduChat.messages');
Route::post('/profile/edu-chat/{id}/send', [EduChatController::class, 'sendMsg'])->name('eduChat.send');

use App\Http\Controllers\Api\Profile\RegionController;
Route::get('/regions', [RegionController::class, 'index'])->name('regions');
Route::post('/region/store', [RegionController::class, 'store'])->name('region.store');

use App\Http\Controllers\Api\Profile\CityController;
Route::get('/cities', [CityController::class, 'index'])->name('cities');
Route::post('/city/store', [CityController::class, 'store'])->name('city.store');

use App\Http\Controllers\Api\Profile\EduInstitutionController;
Route::get('/edu-institutions', [EduInstitutionController::class, 'index'])->name('edu-institutions');
Route::post('/edu-institution/store', [EduInstitutionController::class,'store'])->name('edu-institution.store');
Route::post('/edu-institution/find-or-create-repetitor', [EduInstitutionController::class, 'findOrCreateRepetitor'])->name('edu-institution.find-or-create-repetitor');

use App\Http\Controllers\Api\Auth\RestorePasswordController;

Route::post('/restore-password/{type}/send-code', [RestorePasswordController::class,'sendCode'])->name('restore-password.send');
Route::post('/restore-password/{type}/confirm-code', [RestorePasswordController::class,'confirmCode'])->name('restore-password.confirm');
Route::post('/restore-password/change', [RestorePasswordController::class,'changePassword'])->name('restore-password.change');



