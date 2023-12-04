<?php

use App\Http\Controllers\CRM\LeadContactController;
use App\Http\Controllers\CRM\LeadContractController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\LeadEstimateController;
use App\Http\Controllers\CRM\LeadNoteController;
use App\Http\Controllers\CRM\LeadProposalController;
use App\Http\Controllers\CRM\LeadTaskController;
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
                        Route::get('/destroy/{leadContact}', 'destroy');
                        Route::post('/bulk_delete', 'bulkDelete')->name('lead.contact.bulk_delete');
                    });
                });

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

                // Route::group(['as' => 'lead.'], function () {
                //     Route::resource('/proposals', LeadProposalController::class);
                //     Route::controller(LeadProposalController::class)->group(function () {
                //         Route::prefix('proposals')->group(function () {
                //             Route::get('/datatable', 'datatable')->name('proposals.datatable');
                //             Route::post('/bulk_delete', 'bulkDelete')->name('proposals.bulk_delete');
                //         });
                //     });
                // });

                // New
                Route::controller(LeadProposalController::class)->group(function () {
                    Route::prefix('proposals')->group(function () {
                        Route::get('/', 'index')->name('lead.proposals.index');
                        Route::get('/datatable', 'datatable')->name('lead.proposals.datatable');
                        Route::post('/store', 'store')->name('lead.proposals.store');
                        Route::get('/edit/{leadProposal}', 'edit');
                        Route::post('/update/{leadProposal}', 'update')->name('lead.proposals.update');
                        Route::get('/destroy/{leadProposal}', 'destroy');
                        Route::post('/bulk_delete', 'bulkDelete')->name('lead.proposals.bulk_delete');
                    });
                });

                Route::controller(LeadContractController::class)->group(function () {
                    Route::prefix('contracts')->group(function () {
                        Route::get('/', 'index')->name('lead.contracts.index');
                        Route::get('/datatable', 'datatable')->name('lead.contracts.datatable');
                        Route::post('/store', 'store')->name('lead.contracts.store');
                        Route::get('/edit/{leadContract}', 'edit');
                        Route::post('/update/{leadContract}', 'update')->name('lead.contracts.update');
                        Route::get('/destroy/{leadContract}', 'destroy');
                        Route::post('/bulk_delete', 'bulkDelete')->name('lead.contracts.bulk_delete');
                    });
                });

                Route::controller(LeadNoteController::class)->group(function () {
                    Route::prefix('notes')->group(function () {
                        Route::get('/', 'index')->name('lead.notes.index');
                        Route::get('/datatable', 'datatable')->name('lead.notes.datatable');
                        Route::post('/store', 'store')->name('lead.notes.store');
                        Route::get('/edit/{leadNote}', 'edit');
                        Route::post('/update/{leadNote}', 'update')->name('lead.notes.update');
                        Route::get('/destroy/{leadNote}', 'destroy');
                        Route::post('/bulk_delete', 'bulkDelete')->name('lead.notes.bulk_delete');
                    });
                });
            });
        });
    });
});
