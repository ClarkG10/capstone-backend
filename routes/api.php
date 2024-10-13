<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\DonorController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\api\StaffController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\api\StockInController;
use App\Http\Controllers\api\StockOutController;
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

// Ian nara imong API endpoint
Route::get('/mobile/event', [EventController::class,                    'eventIndex']);
Route::get('/mobile/inventory', [InventoryController::class,            'inventoryIndex']);
Route::get('/mobile/organization', [OrganizationController::class,      'organizationIndex']);
Route::get('/mobile/donor', [DonorController::class,                    'donorIndex']);
Route::post('/donor/register', [DonorController::class,                 'register'])->name('donor.register');
Route::post('donor/login', [DonorController::class,                     'login'])->name('donor.login');
Route::post('donor/logout', [DonorController::class,                    'logout'])->middleware('auth:sanctum');
Route::put('/donor/status/{id}', [DonorController::class,               'updateStatus'])->middleware('auth:sanctum')->name('status.update');
// Gamita ni pang store og details ian, dili lang pang update
Route::put('/donor/{id}', [DonorController::class,                      'update'])->middleware('auth:sanctum')->name('donor.update');
// 

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
        Route::get('/event/all',                    'report');
        Route::get('/event/{id}',                   'show');
        Route::post('/event',                       'store')->name('event.store');
        Route::put('/event/{id}',                   'update');
        Route::put('/event/eventInfo/{id}',         'updateEvent')->name('event.update');
        Route::put('/event/status/{id}',            'updateStatus')->name('event.status');
        Route::delete('/event/{id}',                'destroy');
    });

    Route::controller(InventoryController::class)->group(function () {
        Route::get('/inventory',                        'index');
        Route::get('/inventory/all',                    'report');
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
        Route::get('/bloodrequest/all',               'report');
        Route::get('/bloodrequest/{id}',              'show');
        Route::post('/bloodrequest',                  'store')->name('request.store');
        Route::put('/bloodrequest/status/{id}',       'updateStatus')->name('status.update');
        Route::put('/bloodrequest/{id}',              'update')->name('request.update');
        Route::delete('/bloodrequest/{id}',           'destroy');
    });

    Route::controller(DonorController::class)->group(function () {
        Route::get('/donor',                   'index');
        Route::post('donor',                   'store')->name('donor.store');
        Route::get('/donor/all',               'report');
        Route::get('/donor/{id}',              'show');
        Route::delete('/donor/{id}',           'destroy');
    });

    Route::controller(StaffController::class)->group(function () {
        Route::get('/staff',                   'index');
        Route::get('/staff/all',               'indexAll');
        Route::get('/staff/{id}',              'show');
        Route::post('/staff',                  'store')->name('staff.store');
        Route::put('/staff/role/{id}',         'updateRole')->name('role.update');
        Route::delete('/staff/{id}',           'destroy');
        Route::get('/staff/profile',           'showProfile');
    });

    Route::controller(StockInController::class)->group(function () {
        Route::get('/stockIn',                   'index');
        Route::post('/stockIn',                  'store')->name('stockIn.store');
        Route::delete('/stockIn/{id}',           'destroy');
    });

    Route::controller(StockOutController::class)->group(function () {
        Route::get('/stockOut',                   'index');
        Route::post('/stockOut',                  'store')->name('stockOut.store');
        Route::delete('/stockOut/{id}',           'destroy');
    });
});
