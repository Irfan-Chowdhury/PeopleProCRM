<?php $__env->startSection('content'); ?>
    <div class="col-md-12 p-3">

        <div class="col-md-3 p-3">
            <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none"><i
                        class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
        </div>

        <div class="card invoice_details">
            <div class="card-body" id="invoice_details">
                <h2><?php echo e($company->company_name); ?>

                    <small class="pull-right"><?php echo e(trans('file.Date')); ?>-<?php echo e(date('d-m-Y')); ?></small>
                </h2>
                <hr>

                <div class="row">
                    <div class="col-sm-4 company-col"> <?php echo e(trans('file.From')); ?>

                        <address>
                            <strong><?php echo e($company->company_name); ?></strong><br>
                            <?php echo e($location->address1); ?><br>
                            <?php echo e($location->city); ?>, <?php echo e($location->zip); ?><br>
                            <?php echo e($location->country); ?><br/>
                            Phone: <?php echo e($company->contact_no); ?>      </address>
                    </div>

                    <div class="col-sm-4 client-col"> <?php echo e(trans('file.To')); ?>

                        <address>
                            <strong><?php echo e($client->name); ?></strong><br>
                            <?php echo e($client->company_name); ?><br>
                            <?php echo e($client->address1 ?? ''); ?> <?php echo e($client->address2 ?? ''); ?><br>
                            Phone: <?php echo e($client->contact_no); ?><br>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col"><b><?php echo e(trans('file.Invoice')); ?>

                            # <?php echo e($invoice->invoice_number); ?></b><br>
                        <br>
                        <b><?php echo e(__('Payment Date')); ?>: </b> <?php echo e(isset($invoice->invoicePayment->date) ? $invoice->invoicePayment->date : 'NONE'); ?><br/>
                        <span class="label label-danger">
                            
                        <b><?php echo e(__('Payment Status')); ?>: </b>
                        <?php if(isset($invoice->invoicePayment)): ?>
                            <?php if($invoice->invoicePayment->payment_status == 'pending'): ?>
                                <span class="p-1 badge badge-pill badge-warning"><?php echo e(ucwords(str_replace('_', ' ',$invoice->invoicePayment->payment_status))); ?></span>
                            <?php elseif($invoice->invoicePayment->payment_status == 'completed'): ?>
                                <span class="p-1 badge badge-pill badge-success"><?php echo e(ucwords(str_replace('_', ' ',$invoice->invoicePayment->payment_status))); ?></span>
                            <?php else: ?>
                                <span class="p-1 badge badge-pill badge-danger"><?php echo e(ucwords(str_replace('_', ' ',$invoice->invoicePayment->payment_status))); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </span>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th class="py-3"> #</th>
                                <th class="py-3"> <?php echo e(__('Item')); ?> </th>
                                <th class="py-3"> <?php echo e(__('Qty')); ?> </th>
                                <th class="py-3"> <?php echo e(__('Unit Price')); ?> </th>
                                <th class="py-3"> <?php echo e(__('Tax Rate')); ?> </th>
                                <th class="py-3"> <?php echo e(__('Sub Total')); ?> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $invoice->invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invoiceItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="py-3">
                                        <div class="font-weight-semibold"><?php echo e($key+1); ?></div>
                                    </td>
                                    <td class="py-3">
                                        <div class="font-weight-semibold"><?php echo e(isset($invoiceItem->item) ? $invoiceItem->item->title : ''); ?></div>
                                    </td>
                                    <td class="py-3"><strong><?php echo e($invoiceItem->item_qty); ?></strong></td>
                                    <td class="py-3"><strong><?php echo e($invoiceItem->item_unit_price); ?></strong></td>
                                    <td class="py-3"><strong><?php echo e($invoiceItem->item_tax_rate); ?></strong></td>
                                    <td class="py-3"><strong><?php echo e($invoiceItem->item_sub_total); ?></strong></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row float-right mr-5">
                    <!-- /.col -->
                    <div class="col-xs-6">
                        &nbsp;
                    </div>
                    <div class="col-lg">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th class="w-50"><?php echo e(__('Sub Total')); ?>:</th>
                                    <td><?php echo e($invoice->sub_total); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('file.Tax')); ?></th>
                                    <td> <?php echo e($invoice->total_tax); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('file.Discount')); ?>:</th>
                                    <td><?php echo e($invoice->total_discount); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('file.Total')); ?>:</th>
                                    <td><?php echo e($invoice->grand_total); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.row -->

                <!-- /.row (main row) -->
            </div>
        </div>
    </div>

    <script>
        (function($) {
            "use strict";

            $("#print-btn").on("click", function () {
                let divToPrint = document.getElementById('invoice_details');
                let newWin = window.open('', 'Print-Window');
                newWin.document.open();
                newWin.document.write('<link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.invoice_details { max-width:100%;} }</style><body onload="window.print()">' + divToPrint.innerHTML + '</body>');
                newWin.document.close();
                setTimeout(function () {
                    newWin.close();
                }, 10);
            });

        })(jQuery);
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/client/invoice_show.blade.php ENDPATH**/ ?>