<?php

use App\Domain\Address\AddressController;
use App\Domain\Person\PersonController;
use App\Domain\Profile\ProfileController;
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

Route::group([
    'prefix' => 'address',
], function () {
    Route::post('/create', [AddressController::class, 'store'])->name('address.create');
    Route::delete('/destroyById/{id}', [AddressController::class, 'destroy'])->name('address.destroyById');
    Route::get('/findAll', [AddressController::class, 'index'])->name('address.findAll');
});

Route::group([
    'prefix' => 'profile',
], function () {
    Route::post('/create', [ProfileController::class, 'store'])->name('profile.create');
    Route::delete('/destroyById/{id}', [ProfileController::class, 'destroy'])->name('profile.destroyById');
    Route::get('/findAll', [ProfileController::class, 'index'])->name('profile.findAll');
});

Route::group([
    'prefix' => 'person',
], function () {
    Route::post('/create', [PersonController::class, 'store'])->name('person.create');
    Route::put('/updateById/{id}', [PersonController::class, 'update'])->name('person.updateById');
    Route::delete('/destroyById/{id}', [PersonController::class, 'destroy'])->name('person.destroyById');
    Route::get('/findById/{id}', [PersonController::class, 'findById'])->name('person.findById');
    Route::get('/findByName/{term}', [PersonController::class, 'findByName'])->name('person.findByName');
    Route::get('/findBySsn/{term}', [PersonController::class, 'findBySsn'])->name('person.findBySsn');
    Route::get('/findByDates', [PersonController::class, 'findByDates'])->name('person.findByDates');
    Route::get('/findAll', [PersonController::class, 'index'])->name('person.findAll');
});
