<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Auth\LoginController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root URL to the login page
Route::get('/', function () {
    return redirect('/login');
});

/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);

/**
 * Public Routes
 */
Route::get('/about', function () {
    return view('about');
});

/**
 * Authenticated Routes
 */
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::middleware('auth')->group(function () {
        /**
         * Home Routes
         */
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

        /**
         * Role Routes
         */
        Route::resource('roles', RolesController::class);

        /**
         * Permission Routes
         */
        Route::resource('permissions', PermissionsController::class);

        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UsersController::class, 'index'])->name('users.index');
            Route::get('/create', [UsersController::class, 'create'])->name('users.create');
            Route::post('/create', [UsersController::class, 'store'])->name('users.store');
            Route::get('/{user}/show', [UsersController::class, 'show'])->name('users.show');
            Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
            Route::patch('/{user}/update', [UsersController::class, 'update'])->name('users.update');
            Route::delete('/{user}/delete', [UsersController::class, 'destroy'])->name('users.destroy');
        });

    //         // Routes accessible only to Admin role
    // Route::middleware(['role:Admin'])->group(function () {
    //     Route::resource('users', UsersController::class);
    //     Route::resource('roles', RolesController::class);
    //     Route::resource('permissions', PermissionsController::class);
    // });


        Route::resource('users', UsersController::class);
  

        

       Route::group(['prefix' => 'assets'], function () {
        Route::get('/', [AssetController::class, 'index'])->name('assets.index');
        Route::get('/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('/', [AssetController::class, 'store'])->name('assets.store');
        Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit'); // ← use model name
        Route::put('/{asset}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
    });

        Route::prefix('expenses')->group(function () {
        // Expense List (Form tab)
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses.index');

        // Create New Expense
        Route::get('/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');

        // Expense Approval Tab
        Route::get('/approval', [ExpenseController::class, 'approvalList'])->name('expenses.approval');
        
        // Approve or Reject actions
        Route::post('/{id}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::post('/{id}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');

    });

    });
});
        