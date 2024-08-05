<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/profile/show',  [ProfileController::class, 'show']);

    Route::controller(UserController::class)->group(function () {
        Route::get('/user/{id}',                'show');
        Route::put('/user/{id}',                'update')->name('user.update');
        Route::put('/user/email/{id}',          'email')->name('user.email');
        Route::put('/user/password/{id}',       'password')->name('user.password');
        Route::delete('/user/{id}',             'destroy');
        Route::get('/profile',                  'showProfile');
    });

    Route::controller(EventController::class)->group(function () {
        Route::get('/event',                        'index');
        Route::get('/event/export',                 'report');
        Route::get('/event/{id}',                   'show');
        Route::post('/event',                       'store')->name('event.store');
        Route::put('/event/{id}',                   'update');
        Route::put('/event/eventInfo/{id}',         'updateEvent')->name('event.update');
        Route::put('/event/status/{id}',            'updateStatus')->name('event.status');
        Route::delete('/event/{id}',                'destroy');
    });

    Route::controller(InventoryController::class)->group(function () {
        Route::get('/inventory',                        'index');
        Route::get('/inventory/export',                 'report');
        Route::get('/inventory/{id}',                   'show');
        Route::post('/inventory',                       'store')->name('inventory.store');
        Route::put('/inventory/{id}',                   'update');
        Route::put('/inventory/bloodunits/{id}',        'bloodUnits')->name('inventory.update');
        Route::delete('/inventory/{id}',                'destroy');
    });

    Route::controller(OrganizationController::class)->group(function () {
        Route::get('/organization',                    'index');
        Route::get('/organization/{id}',               'show');
        Route::post('/organization',                   'store')->name('organization.store');
        Route::put('/organization/{id}',               'updateOrganization')->name('organization.update');
        Route::delete('/organization/{id}',            'destroy');
    });

    Route::controller(RequestController::class)->group(function () {
        Route::get('/bloodrequest',                   'index');
        Route::get('/bloodrequest/export',            'report');
        Route::get('/bloodrequest/{id}',              'show');
        Route::post('/bloodrequest',                  'store')->name('request.store');
        Route::put('/bloodrequest/status/{id}',       'updateStatus')->name('request.update');
        Route::delete('/bloodrequest/{id}',           'destroy');
    });
});
