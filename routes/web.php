<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TopicDetailController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\TopicContoller as AdminTopicContoller;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

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

Route::get('/', function () {
    return redirect()->route('home');
});

require __DIR__.'/auth.php';

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('tranding', [HomeController::class, 'tranding'])->name('tranding');
Route::post('t/likes', [TopicDetailController::class, 'store_like'])->name('topic.like.store');
Route::post('t/share', [TopicDetailController::class, 'store_share'])->name('topic.share.store');

Route::get('t/create', [TopicController::class, 'index'])->name('topic.create.index');
Route::post('t/create', [TopicController::class, 'store'])->name('topic.create.store');

Route::post('t/comment/rmv', [TopicDetailController::class, 'destroy'])->name('topic.comment.destroy');

Route::get('t/{url}', [TopicDetailController::class, 'index'])->name('topic.detail');
Route::post('t/{url}', [TopicDetailController::class, '_store'])->name('topic.comment.store');

Route::get('group', [GroupController::class, 'index'])->name('group');
Route::get('g/{url}', [GroupController::class, 'posts'])->name('group.posts');

Route::get('user', [UserController::class, 'index'])->middleware('auth')->name('user');



Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login.index');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::middleware(['authAdmin'])->group(function () {
        Route::get("home", [AdminHomeController::class, 'index'])->name('home');
        Route::get("chart/pie", [AdminHomeController::class, 'chartPie'])->name("data.pie");
        Route::get("chart/batang", [AdminHomeController::class, 'chartBatang'])->name("data.batang");

        Route::prefix('topic')->as('topic.')->group(function () {
            Route::get('/', [AdminTopicContoller::class, 'index'])->name('index');
            Route::get('/group/{id}', [AdminTopicContoller::class, 'byGroup'])->name('byGroup');
            Route::get('/user/{id}', [AdminTopicContoller::class, 'byUser'])->name('byUser');
            Route::get('/{url}', [AdminTopicContoller::class, 'show'])->name('detail');

            Route::get("/{url}/chart/pie", [AdminTopicContoller::class, 'chartPie'])->name("data.pie");
            Route::get("/{url}/chart/batang", [AdminTopicContoller::class, 'chartBatang'])->name("data.batang");
        });

        Route::prefix('group')->as('group.')->group(function () {
            Route::get('/', [AdminGroupController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminGroupController::class, 'show'])->name('show');
            Route::put('/{id}', [AdminGroupController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminGroupController::class, 'destroy'])->name('destroy');
            Route::get('/create', [AdminGroupController::class, 'create'])->name('create');
            Route::post('/', [AdminGroupController::class, 'store'])->name('store');
        });

        Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminUserController::class, 'show'])->name('show');
            Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
        });
    });
});
