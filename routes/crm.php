<?php

use App\Http\Controllers\CRM\LeadContactController;
use App\Http\Controllers\CRM\LeadController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['XSS']], function () {

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

            Route::prefix('details/{lead}')->group(function () {

                Route::controller(LeadContactController::class)->group(function () {
                    Route::prefix('contact')->group(function () {
                        Route::get('/', 'index')->name('lead.contact.index');
                        Route::get('/datatable', 'datatable')->name('lead.contact.datatable');
                        Route::post('/store', 'store')->name('lead.contact.store');
                        Route::get('/edit/{leadContact}', 'edit');
                        Route::post('/update/{leadContact}', 'update')->name('lead.contact.update');
                        Route::get('/destroy/{leadContact}', 'destroy')->name('lead.contact.destroy');
                        Route::post('/bulk_delete', 'bulkDelete')->name('lead.contact.bulk_delete');
                    });
                });
            });
        });
    });
});
