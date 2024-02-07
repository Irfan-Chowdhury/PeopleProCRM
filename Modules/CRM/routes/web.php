<?php

use Illuminate\Support\Facades\Route;
use Modules\CRM\App\Http\Controllers\CRMController;
use Modules\CRM\App\Http\Controllers\ItemController;
use Modules\CRM\App\Http\Controllers\LeadContactController;
use Modules\CRM\App\Http\Controllers\LeadController;
use Modules\CRM\App\Http\Controllers\LeadInfoController;
use Modules\CRM\App\Http\Controllers\LeadTaskController;

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

Route::group([], function () {
    Route::resource('crm', CRMController::class)->names('crm');
});

Route::prefix('leads')->group(function() {
    Route::controller(LeadController::class)->group(function () {
        Route::get('/', 'index')->name('lead.index');
        Route::get('/datatable', 'datatable')->name('lead.datatable');
        Route::post('/store', 'store')->name('lead.store');
        Route::get('/store', 'store')->name('lead.store');
        Route::get('/edit/{lead}', 'edit')->name('lead.edit');
        Route::post('/update/{lead}', 'update')->name('lead.update');
        Route::get('/destroy/{lead}', 'destroy')->name('lead.destroy');
        Route::post('/bulk_delete', 'bulkDelete')->name('lead.bulk_delete');
    });

    Route::prefix('details/{lead}')->group(function () {
        Route::controller(LeadContactController::class)->group(function () {
            Route::prefix('contact')->group(function () {
                Route::get('/', 'index')->name('lead.contact.index');
                Route::get('/datatable', 'datatable')->name('lead.contact.datatable');
                Route::post('/store', 'store')->name('lead.contact.store');
                Route::get('/edit/{leadContact}', 'edit');
                Route::post('/update/{leadContact}', 'update')->name('lead.contact.update');
                Route::get('/destroy/{leadContact}', 'destroy');
                Route::post('/bulk_delete', 'bulkDelete')->name('lead.contact.bulk_delete');
            });
        });

        Route::get('/lead-info', [LeadInfoController::class, 'show'])->name('lead.info.show');

        Route::controller(LeadTaskController::class)->group(function () {
            Route::prefix('task')->group(function () {
                Route::get('/', 'index')->name('lead.task.index');
                Route::get('/datatable', 'datatable')->name('lead.task.datatable');
                Route::post('/store', 'store')->name('lead.task.store');
                Route::get('/edit/{leadTask}', 'edit');
                Route::post('/update/{leadTask}', 'update')->name('lead.task.update');
                Route::get('/destroy/{leadTask}', 'destroy');
                Route::post('/bulk_delete', 'bulkDelete')->name('lead.task.bulk_delete');
            });
        });

        Route::controller(LeadEstimateController::class)->group(function () {
            Route::prefix('estimate')->group(function () {
                Route::get('/', 'index')->name('lead.estimate.index');
                Route::get('/datatable', 'datatable')->name('lead.estimate.datatable');
                Route::post('/store', 'store')->name('lead.estimate.store');
                Route::get('/edit/{leadEstimate}', 'edit');
                Route::post('/update/{leadEstimate}', 'update')->name('lead.estimate.update');
                Route::get('/destroy/{leadEstimate}', 'destroy');
                Route::post('/bulk_delete', 'bulkDelete')->name('lead.estimate.bulk_delete');
            });
        });
    });


});

Route::prefix('sales')->group(function() {
    Route::controller(ItemController::class)->group(function () {
        Route::prefix('items')->group(function () {
            Route::get('/', 'index')->name('items.index');
            Route::get('/datatable', 'datatable')->name('items.datatable');
            Route::post('/store', 'store')->name('items.store');
            Route::get('/edit/{item}', 'edit')->name('items.edit');
            Route::post('/update/{item}', 'update')->name('items.update');
            Route::get('/destroy/{item}', 'destroy')->name('items.destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('items.bulk_delete');
        });
    });
});
