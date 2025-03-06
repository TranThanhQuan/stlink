<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\AdminAuthController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // link
    Route::get('/links', [LinkController::class, 'index'])->name('admin.links.index');
    Route::post('/links/store', [LinkController::class, 'store'])->name('admin.links.store');
    Route::put('/links/update/{id}', [LinkController::class, 'update'])->name('admin.links.update');
    Route::delete('/links/destroy/{id}', [LinkController::class, 'destroy'])->name('admin.links.destroy');
    Route::get('/links/view/{id}', [LinkController::class, 'view'])->name('admin.links.view');

    // user
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/view/{id}', [UserController::class, 'view'])->name('admin.users.view');


    //group
    Route::get('/groups', [GroupController::class, 'index'])->name('admin.groups.index');
    Route::post('/groups/store', [GroupController::class, 'store'])->name('admin.groups.store');
    Route::put('/groups/update/{id}', [GroupController::class, 'update'])->name('admin.groups.update');
    Route::delete('/groups/destroy/{id}', [GroupController::class, 'destroy'])->name('admin.groups.destroy');
    Route::get('/groups/permission/{id}', [GroupController::class, 'permission'])->name('admin.groups.permission');
    Route::get('/permission/{id}', [GroupController::class, 'permission'])->name('admin.groups.permission');


});


Route::group(['prefix' => 'admin' , 'middleware' => 'redirectAdmin'],function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

require __DIR__.'/auth.php';
