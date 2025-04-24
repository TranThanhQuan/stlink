<?php

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserLinkController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\UserDashboardController;

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




Route::get('/', [UserController::class, 'home'])->name('home');


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
*/



Route::middleware(['user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // link
    Route::get('/links', [UserLinkController::class, 'index'])->name('user.links.index');
    Route::post('/links/store', [UserLinkController::class, 'store'])->name('user.links.store');
    Route::put('/links/update/{id}', [UserLinkController::class, 'update'])->name('user.links.update');
    Route::delete('/links/destroy/{id}', [UserLinkController::class, 'destroy'])->name('user.links.destroy');
    Route::get('/links/view/{id}', [UserLinkController::class, 'view'])->name('user.links.view');

    // user
    Route::get('/infor', [UserController::class, 'index'])->name('user.infor.index');

    Route::post('/user/store', [UserController::class, 'store'])->name('user.user.store');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.user.update');
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.user.destroy');
    Route::get('/user/view/{id}', [UserController::class, 'view'])->name('user.user.view');
});

Route::group(['middleware' => 'redirectUser'],function () {
    Route::get('dang-nhap', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('dang-nhap', [UserAuthController::class, 'login'])->name('user.login.post');
    Route::post('logout', [UserAuthController::class, 'logout'])->name('user.logout');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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



Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // link
    Route::get('/links', [LinkController::class, 'index'])->name('admin.links.index');
    Route::post('/links/store', [LinkController::class, 'store'])->name('admin.links.store');
    Route::put('/links/update/{id}', [LinkController::class, 'update'])->name('admin.links.update');
    Route::delete('/links/destroy/{id}', [LinkController::class, 'destroy'])->name('admin.links.destroy');
    Route::get('/links/view/{id}', [LinkController::class, 'view'])->name('admin.links.view');

    // user
    Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::post('/users/store', [AdminController::class, 'store'])->name('admin.users.store');
    Route::put('/users/update/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/view/{id}', [AdminController::class, 'view'])->name('admin.users.view');

    //group
    Route::get('/groups', [GroupController::class, 'index'])->name('admin.groups.index');
    Route::post('/groups/store', [GroupController::class, 'store'])->name('admin.groups.store');
    Route::put('/groups/update/{id}', [GroupController::class, 'update'])->name('admin.groups.update');
    Route::delete('/groups/destroy/{id}', [GroupController::class, 'destroy'])->name('admin.groups.destroy');
    Route::get('/groups/permission/{id}', [GroupController::class, 'permission'])->name('admin.groups.permission');
    Route::put('/groups/permission/{id}', [GroupController::class, 'updatePermission'])->name('admin.groups.updatePermission');

});


Route::group(['prefix' => 'admin' , 'middleware' => 'redirectAdmin'],function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});




/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/{short_code}', [LinkController::class, 'tracking']);










// Fallback cho tất cả route không khớp
Route::fallback(function () {
    return Inertia::render('Errors/NotFound')->toResponse(request())->setStatusCode(404);
});



require __DIR__.'/auth.php';
