<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RevokePermissionFromRoleController;
use App\Http\Controllers\RevokePermissionFromUserController;
use App\Http\Controllers\RemoveRoleFromUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BulletinBoardController;
use App\Http\Controllers\DemographicProfileController;


Route::get('/card1', function () {
    return Inertia::render('Auth/Card1');
})->name('card1');

Route::get('/card2', function () {
    return Inertia::render('Auth/Card2');
})->name('card2');

Route::get('/card3', function () {
    return Inertia::render('Auth/Card3');
})->name('card3');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('/admins', AdminController::class);
Route::resource('/users', UserController::class);
Route::resource('/roles', RoleController::class);
Route::resource('/permissions', PermissionController::class);
Route::resource('/posts', PostController::class);
Route::resource('/bulletinboards', BulletinBoardController::class);
Route::resource('/youthprofiles', DemographicProfileController::class);


Route::delete('/roles/{role}/permissions/{permission}', RevokePermissionFromRoleController::class)
    ->name('roles.permissions.destroy');
Route::delete('/users/{user}/permissions/{permission}', RevokePermissionFromUserController::class)
    ->name('users.permissions.destroy');
Route::delete('/users/{user}/roles/{role}', RemoveRoleFromUserController::class)
    ->name('users.roles.destroy');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

require __DIR__.'/auth.php';
