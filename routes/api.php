<?php

use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(['prefix' => 'users'], function () {
    Route::post('login', [UserController::class, 'login'])->name('users.login');
    Route::post('register', [UserController::class, 'register'])->name('users.register');
    Route::post('/', [UserController::class, 'register'])->name('users.create');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/{id}', [UserController::class, 'register'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}', [UserController::class, 'details'])->name('users.details');
    });
});

Route::group(['prefix' => 'projects'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/', [ProjectController::class, 'create'])->name('projects.create');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/{id}', [ProjectController::class, 'delete'])->name('projects.delete');
        Route::get('/{id}', [ProjectController::class, 'details'])->name('projects.details');

    });
});

Route::group(['prefix' => 'tasks'], function () {
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('/', [TaskController::class, 'create'])->name('tasks.create');
        Route::put('/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{id}', [TaskController::class, 'delete'])->name('tasks.delete');
        Route::get('/{id}', [TaskController::class, 'details'])->name('tasks.details');
        Route::post('/update_status/{id}', [TaskController::class, 'update_status'])->name('tasks.update_status');

    });
});
