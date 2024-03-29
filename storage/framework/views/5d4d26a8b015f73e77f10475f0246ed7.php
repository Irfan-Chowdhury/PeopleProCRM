<?php $__env->startSection('content'); ?>


<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3><?php echo e(__('file.Contract Item Details')); ?></h3></div>
    </div>
</div>

<div class="container card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <thead>
                    <tr>
                        <th><?php echo e(trans('file.Item')); ?></th>
                        <th><?php echo e(trans('file.Rate')); ?></th>
                        <th><?php echo e(trans('file.Quantity')); ?></th>
                        <th><?php echo e(trans('file.Total')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $contract->contractItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($value->item->title); ?></td>
                            <td><?php echo e($value->rate); ?></td>
                            <td><?php echo e($value->quantity); ?></td>
                            <td><?php echo e($value->quantity * $value->rate); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Tax : <?php echo e($contract->tax->rate); ?>%</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Total : <?php echo e($total); ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Total amount with tax: <?php echo e($totalAmoutWithTax); ?></th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(isset($contract->client_id) && Auth::user()->role_users_id !==3 ? 'layout.main' : 'layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/client/contracts/contract_items_details.blade.php ENDPATH**/ ?>