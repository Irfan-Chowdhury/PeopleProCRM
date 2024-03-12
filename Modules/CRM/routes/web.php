<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use Modules\CRM\App\Http\Controllers\ClientContractController;
use Modules\CRM\App\Http\Controllers\ClientEstimateController;
use Modules\CRM\App\Http\Controllers\ClientProposalController;
use Modules\CRM\App\Http\Controllers\ClientSubscriptionController;
use Modules\CRM\App\Http\Controllers\ContractController;
use Modules\CRM\App\Http\Controllers\ContractItemController;
use Modules\CRM\App\Http\Controllers\CRMController;
use Modules\CRM\App\Http\Controllers\EstimateController;
use Modules\CRM\App\Http\Controllers\EstimateFormController;
use Modules\CRM\App\Http\Controllers\EstimateItemController;
use Modules\CRM\App\Http\Controllers\ItemCategoryController;
use Modules\CRM\App\Http\Controllers\ItemController;
use Modules\CRM\App\Http\Controllers\LeadContactController;
use Modules\CRM\App\Http\Controllers\LeadContractController;
use Modules\CRM\App\Http\Controllers\LeadController;
use Modules\CRM\App\Http\Controllers\LeadEstimateController;
use Modules\CRM\App\Http\Controllers\LeadInfoController;
use Modules\CRM\App\Http\Controllers\LeadNoteController;
use Modules\CRM\App\Http\Controllers\LeadProposalController;
use Modules\CRM\App\Http\Controllers\LeadTaskController;
use Modules\CRM\App\Http\Controllers\OrderController;
use Modules\CRM\App\Http\Controllers\ProposalController;
use Modules\CRM\App\Http\Controllers\ProposalItemController;
use Modules\CRM\App\Http\Controllers\ProspectsController;
use Modules\CRM\App\Http\Controllers\StoreController;
use Modules\CRM\App\Http\Controllers\SubscriptionController;

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

// Route::get('/test', function(OrderController $orderController) {
//     return var_dump($orderController->test());
//     return dd($orderController->test());
// });

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

Route::prefix('subscriptions')->group(function() {
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('/', 'index')->name('subscription.index');
        Route::get('/datatable', 'datatable')->name('subscription.datatable');
        Route::post('/store', 'store')->name('subscription.store');
        Route::get('/edit/{subscription}', 'edit')->name('subscription.edit');
        Route::post('/update/{subscription}', 'update')->name('subscription.update');
        Route::get('/destroy/{subscription}', 'destroy')->name('subscription.destroy');
        Route::post('/bulk_delete', 'bulkDelete')->name('subscription.bulk_delete');
    });
});

Route::prefix('sales')->group(function() {

    Route::prefix('item-categories')->group(function () {
        Route::controller(ItemCategoryController::class)->group(function () {
            Route::get('/', 'index')->name('itemCategory.index');
            Route::get('/datatable', 'datatable')->name('itemCategory.datatable');
            Route::post('/store', 'store')->name('itemCategory.store');
            Route::get('/edit/{itemCategory}', 'edit')->name('itemCategory.edit');
            Route::post('/update/{itemCategory}', 'update')->name('itemCategory.update');
            Route::get('/destroy/{itemCategory}', 'destroy')->name('itemCategory.destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('itemCategory.bulk_delete');
        });
    });

    Route::controller(ItemController::class)->group(function () {
        Route::prefix('items')->group(function () {
            Route::get('/', 'index')->name('items.index');
            Route::get('/datatable', 'datatable')->name('items.datatable');
            Route::post('/store', 'store')->name('items.store');
            Route::get('/show/{item}', 'show')->name('items.show');
            Route::get('/edit/{item}', 'edit')->name('items.edit');
            Route::post('/update/{item}', 'update')->name('items.update');
            Route::get('/destroy/{item}', 'destroy')->name('items.destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('items.bulk_delete');
        });
    });

    Route::controller(StoreController::class)->group(function () {
        Route::prefix('store')->group(function () {
            Route::get('/', 'index')->name('store.index');
            Route::post('/add-to-cart/{item}', 'addToCart')->name('store.addToCart');
            Route::get('/chekout', 'chekout')->name('store.chekout');
            Route::post('/process_order', 'processOrder')->name('store.processOrder');
        });
    });

    Route::controller(OrderController::class)->group(function () {
        Route::prefix('orders')->group(function () {
            Route::get('/', 'index')->name('order.index');
            Route::get('/datatable', 'datatable')->name('order.datatable');
            Route::get('/{order_id}/{status}','orderStatusChange')->name('order.status_change');
        });
    });

    Route::controller(ContractController::class)->group(function () {
        Route::prefix('contracts')->group(function () {
            Route::get('/', 'index')->name('contracts.index');
            Route::get('/datatable', 'datatable')->name('contracts.datatable');
            Route::post('/store', 'store')->name('contracts.store');
            Route::get('/edit/{contract}', 'edit');
            Route::post('/update/{contract}', 'update')->name('contracts.update');
            Route::get('/destroy/{contract}', 'destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('contracts.bulk_delete');

            Route::prefix('{contract}')->group(function () {
                Route::controller(ContractItemController::class)->group(function () {
                    Route::get('items', 'index')->name('contracts.items');
                    Route::post('store', 'store')->name('contracts.items.store');
                    Route::get('/edit/{contractItem}', 'edit')->name('contracts.items.edit');
                    Route::post('/update/{contractItem}', 'update')->name('contracts.items.update');
                    Route::get('/destroy/{contractItem}', 'destroy')->name('contracts.items.destroy');
                    Route::post('/bulk_delete', 'bulkDelete')->name('contracts.items.bulk_delete');
                });
            });
        });
    });
});

// prospects
Route::prefix('prospects')->group(function() {
    Route::prefix('proposals')->group(function() {
        Route::controller(ProposalController::class)->group(function () {
            Route::get('/', 'index')->name('prospects.proposals.index');
            Route::get('/datatable', 'datatable')->name('prospects.proposals.datatable');
            Route::post('/store', 'store')->name('prospects.proposals.store');
            Route::get('/edit/{proposal}', 'edit')->name('prospects.proposals.edit');
            Route::post('/update/{proposal}', 'update')->name('prospects.proposals.update');
            Route::get('/destroy/{proposal}', 'destroy')->name('prospects.proposals.destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('prospects.proposals.bulk_delete');
        });
        Route::prefix('{proposal}')->group(function () {
            Route::controller(ProposalItemController::class)->group(function () {
                Route::get('items', 'index')->name('prospects.proposals.items');
                Route::post('store', 'store')->name('prospects.proposals.items.store');
                Route::get('/edit/{proposalItem}', 'edit')->name('prospects.proposals.items.edit');
                Route::post('/update/{proposalItem}', 'update')->name('prospects.proposals.items.update');
                Route::get('/destroy/{proposalItem}', 'destroy')->name('prospects.proposals.items.destroy');
                Route::post('/bulk_delete', 'bulkDelete')->name('prospects.proposals.items.bulk_delete');
            });
        });

    });

    Route::prefix('estimates')->group(function() {
        Route::controller(EstimateController::class)->group(function () {
            Route::get('/', 'index')->name('prospects.estimates.index');
            Route::get('/datatable', 'datatable')->name('prospects.estimates.datatable');
            Route::post('/store', 'store')->name('prospects.estimates.store');
            Route::get('/edit/{estimate}', 'edit')->name('prospects.estimates.edit');
            Route::post('/update/{estimate}', 'update')->name('prospects.estimates.update');
            Route::get('/destroy/{estimate}', 'destroy')->name('prospects.estimates.destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('prospects.estimates.bulk_delete');
        });
        Route::prefix('{estimate}')->group(function () {
            Route::controller(EstimateItemController::class)->group(function () {
                Route::get('items', 'index')->name('prospects.estimates.items');
                Route::post('store', 'store')->name('prospects.estimates.items.store');
                Route::get('/edit/{estimateItem}', 'edit')->name('prospects.estimates.items.edit');
                Route::post('/update/{estimateItem}', 'update')->name('prospects.estimates.items.update');
                Route::get('/destroy/{estimateItem}', 'destroy')->name('prospects.estimates.items.destroy');
                Route::post('/bulk_delete', 'bulkDelete')->name('prospects.estimates.items.bulk_delete');
            });
        });

    });

    Route::prefix('estimate-forms')->group(function() {
        Route::controller(EstimateFormController::class)->group(function () {
            Route::get('/', 'index')->name('prospects.estimate-forms.index');
            Route::get('/datatable', 'datatable')->name('prospects.estimate-forms.datatable');
            Route::post('/store', 'store')->name('prospects.estimate-forms.store');
            Route::get('/edit/{estimateForm}', 'edit')->name('prospects.estimate-forms.edit');
            Route::post('/update/{estimateForm}', 'update')->name('prospects.estimate-forms.update');
            Route::get('/destroy/{estimateForm}', 'destroy')->name('prospects.estimate-forms.destroy');
            Route::post('/bulk_delete', 'bulkDelete')->name('prospects.estimate-forms.bulk_delete');
        });
    });
});

Route::get('/client-overview', [ClientController::class, 'overview'])->name('client.overview');


Route::prefix('client')->group(function() {

    Route::prefix('contracts')->group(function() {
        Route::get('/', [ClientContractController::class, 'index'])->name('client.contracts.index');
        Route::get('/datatable', [ClientContractController::class, 'datatable'])->name('client.contracts.datatable');
        Route::get('/{contract}', [ClientContractController::class, 'contractItemDetails'])->name('client.contracts.contractItemDetails');
    });

    Route::prefix('proposals')->group(function() {
        Route::get('/', [ClientProposalController::class, 'index'])->name('client.proposals.index');
        Route::get('/datatable', [ClientProposalController::class, 'datatable'])->name('client.proposals.datatable');
        Route::get('/{proposal}', [ClientProposalController::class, 'proposalItemDetails'])->name('client.proposals.proposalItemDetails');
    });

    Route::prefix('subscriptions')->group(function() {
        Route::controller(ClientSubscriptionController::class)->group(function () {
            Route::get('/', 'index')->name('client.subscription.index');
            Route::get('/datatable', 'datatable')->name('client.subscription.datatable');
        });
    });

    Route::prefix('estimates')->group(function() {
        Route::get('/', [ClientEstimateController::class, 'index'])->name('client.estimates.index');
        Route::get('/datatable', [ClientEstimateController::class, 'datatable'])->name('client.estimates.datatable');
        Route::get('/{estimate}', [ClientEstimateController::class, 'estimateItemDetails'])->name('client.estimates.estimateItemDetails');
    });

});


