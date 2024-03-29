<?php

use Illuminate\Support\Facades\Route;
use Modules\CRM\App\Http\Controllers\ClientContractController;
use Modules\CRM\App\Http\Controllers\ClientController;
use Modules\CRM\App\Http\Controllers\ClientEstimateController;
use Modules\CRM\App\Http\Controllers\ClientInvoiceController;
use Modules\CRM\App\Http\Controllers\ClientProposalController;
use Modules\CRM\App\Http\Controllers\ClientStoreController;
use Modules\CRM\App\Http\Controllers\ClientSubscriptionController;
use Modules\CRM\App\Http\Controllers\ContractController;
use Modules\CRM\App\Http\Controllers\ContractItemController;
use Modules\CRM\App\Http\Controllers\CRMController;
use Modules\CRM\App\Http\Controllers\EstimateController;
use Modules\CRM\App\Http\Controllers\EstimateFormController;
use Modules\CRM\App\Http\Controllers\EstimateItemController;
use Modules\CRM\App\Http\Controllers\InvoiceController;
use Modules\CRM\App\Http\Controllers\InvoicePaymentController;
use Modules\CRM\App\Http\Controllers\ItemCategoryController;
use Modules\CRM\App\Http\Controllers\ItemController;
use Modules\CRM\App\Http\Controllers\LeadContactController;
use Modules\CRM\App\Http\Controllers\LeadContractController;
use Modules\CRM\App\Http\Controllers\LeadController;
use Modules\CRM\App\Http\Controllers\LeadEstimateController;
use Modules\CRM\App\Http\Controllers\LeadFileController;
use Modules\CRM\App\Http\Controllers\LeadInfoController;
use Modules\CRM\App\Http\Controllers\LeadNoteController;
use Modules\CRM\App\Http\Controllers\LeadProposalController;
use Modules\CRM\App\Http\Controllers\LeadTaskController;
use Modules\CRM\App\Http\Controllers\OrderController;
use Modules\CRM\App\Http\Controllers\PaymentController;
use Modules\CRM\App\Http\Controllers\ProposalController;
use Modules\CRM\App\Http\Controllers\ProposalItemController;
use Modules\CRM\App\Http\Controllers\ProspectsController;
use Modules\CRM\App\Http\Controllers\ReportController;
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

            Route::controller(LeadFileController::class)->group(function () {
                Route::prefix('files')->group(function () {
                    Route::get('/', 'index')->name('lead.files.index');
                    Route::get('/datatable', 'datatable')->name('lead.files.datatable');
                    Route::post('/store', 'store')->name('lead.files.store');
                    Route::get('/destroy/{leadFile}', 'destroy');
                    Route::post('/bulk_delete', 'bulkDelete')->name('lead.files.bulk_delete');
                    Route::get('file_download/{leadFile}', 'download')->name('lead.files.downloadFile');

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
                Route::get('/details/{order}','orderDetails');
                Route::get('/{order_id}/{status}','orderStatusChange')->name('order.status_change');
                Route::get('{order}','destroy');
            });
        });


        Route::controller(InvoicePaymentController::class)->group(function () {
            Route::prefix('invoice-payments')->group(function () {
                Route::get('/', 'index')->name('invoice-payments.index');
                Route::get('/datatable', 'datatable')->name('invoice-payments.datatable');
                Route::post('/store', 'store')->name('invoice-payments.store');
                Route::get('/destroy/{invoicePayment}', 'destroy');
                Route::post('/bulk_delete', 'bulkDelete')->name('invoice-payments.bulk_delete');
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


    Route::prefix('report')->group(function () {
        Route::get('invoice', [ReportController::class, 'invoice'])->name('report.invoice');
        Route::get('invoice-payment', [ReportController::class, 'invoicePayment'])->name('report.invoice-payment');
        Route::get('team-project', [ReportController::class, 'teamProjectReport'])->name('report.project');
        Route::get('client-project', [ReportController::class, 'clientProjectReport'])->name('report.client-project');
    });

    Route::prefix('project-management')->group(function () {
        Route::post('invoices/{id}/update', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/status/{status_id}/{invoice_id}', [InvoiceController::class, 'status'])->name('invoices.status');
        Route::get('invoices/{id}/delete', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::get('invoices/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::get('invoices/download/{id}', [InvoiceController::class, 'download'])->name('invoices.downloadFile');
        Route::post('invoices/delete/selected', [InvoiceController::class, 'delete_by_selection'])->name('mass_delete_invoices');
    });

    Route::prefix('clients')->group(function () {
        // Route::resource('/', ClientController::class, ['names' => 'clients'])->except(['destroy', 'create', 'update', 'show']);
        Route::resource('/', ClientController::class, ['names' => 'clients'])->only(['index', 'store']);
        Route::get('{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::post('update', [ClientController::class, 'update'])->name('clients.update');
        Route::get('{id}/delete', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::post('delete/selected', [ClientController::class, 'delete_by_selection'])->name('mass_delete_clients');
        Route::get('/overview', [ClientController::class, 'overview'])->name('client.overview');
    });



    // ============ Client Section ===========
    Route::prefix('client')->group(function() {

        Route::prefix('contracts')->group(function() {
            Route::get('/', [ClientContractController::class, 'index'])->name('client.contracts.index');
            Route::get('/datatable', [ClientContractController::class, 'datatable'])->name('client.contracts.datatable');
            Route::get('/{contract}', [ClientContractController::class, 'contractItemDetails'])->name('client.contracts.contractItemDetails');
            Route::get('/show/{client_id}', [ClientContractController::class, 'show'])->name('client.contracts.show');
        });

        Route::prefix('proposals')->group(function() {
            Route::get('/', [ClientProposalController::class, 'index'])->name('client.proposals.index');
            Route::get('/datatable', [ClientProposalController::class, 'datatable'])->name('client.proposals.datatable');
            Route::get('/{proposal}', [ClientProposalController::class, 'proposalItemDetails'])->name('client.proposals.proposalItemDetails');
            Route::get('/show/{client_id}', [ClientProposalController::class, 'show'])->name('client.proposals.show');
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

        Route::prefix('orders')->group(function() {
            Route::get('/', [OrderController::class, 'clientOrders'])->name('client.clientOrders');
        });

        Route::controller(ClientStoreController::class)->group(function () {
            Route::prefix('store')->group(function () {
                Route::get('/', 'index')->name('client.store.index');
                Route::get('/chekout', 'chekout')->name('client.store.chekout');
                Route::post('/process_order', 'processOrder')->name('client.store.processOrder');
            });
        });


        Route::get('/invoices', [ClientInvoiceController::class, 'invoices'])->name('clientInvoice');
        Route::get('/invoices/payment', [ClientInvoiceController::class, 'paidInvoices'])->name('clientInvoicePaid');

    });

});




