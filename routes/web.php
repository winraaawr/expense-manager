<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/users', [ProfileController::class, 'index', RoleController::class, 'getRoles'],)
    ->middleware(['auth', 'verified'])->name('users');

//Roles Route
Route::middleware('auth')->group(function(){
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/*', [RoleController::class, 'show'])->name('roles.show');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::put('/profile/{profile}', [ProfileController::class, 'updateAdmin'])->name('profile.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/{role}', [ProfileController::class, 'adminDestroy'])->name('profile.admindestroy');
});


//Expenses Route
Route::middleware('auth')->group(function(){
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses');
});

//Categories Route
Route::middleware('auth')->group(function(){
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


require __DIR__ . '/auth.php';
