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

Route::get('/dashboard', [ExpenseController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');


//Users Route
Route::middleware('auth')->group(function(){
    Route::get('/users', [ProfileController::class, 'index', RoleController::class, 'getRoles'],)->middleware('is_admin')->name('users');
    Route::post('/users', [ProfileController::class, 'store'])->name('users.store');
    Route::put('/profile/{user}', [ProfileController::class, 'updateAdmin'])->name('users.update');
    Route::delete('/profile/{user}', [ProfileController::class, 'adminDestroy'])->name('users.destroy');
});

//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});

//Roles Route
Route::middleware('auth')->group(function(){
    Route::get('/roles', [RoleController::class, 'index'])->middleware('is_admin')->name('roles');
    Route::get('/*', [RoleController::class, 'show'])->name('roles.show');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

//Expenses Route
Route::middleware('auth')->group(function(){
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});

//Categories Route
Route::middleware('auth')->group(function(){
    Route::get('/categories', [CategoryController::class, 'index'])->middleware('is_admin')->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->middleware('is_admin')->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->middleware('is_admin')->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('is_admin')->name('categories.destroy');
});


require __DIR__ . '/auth.php';
