<?php $__env->startSection('content'); ?>

<section>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-30px">
            <div><h1 class="thin-text"><?php echo e(trans('file.Overview')); ?> </h1></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Total Client')); ?></strong></div>
                        <div class="count-number employee-count"><?php echo e(count($clients)); ?></div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Total Subscription')); ?></strong></div>
                        <div class="count-number employee-count"><?php echo e(count($subscriptions)); ?></div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Total Contract')); ?></strong></div>
                        <div class="count-number employee-count"><?php echo e(count($contracts)); ?></div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="wrapper count-title text-left">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Clients have paid invoices')); ?></strong></div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped" style="width:<?php echo e($invoices->paid_percentage); ?>%"><?php echo e($invoices->paid_percentage); ?>%</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-left">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Clients have unpaid invoices')); ?></strong></div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped" style="width:<?php echo e($invoices->unpaid_percentage); ?>%"><?php echo e($invoices->unpaid_percentage); ?>%</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-left">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Clients have sent invoices')); ?></strong></div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped" style="width:<?php echo e($invoices->sent_percentage); ?>%"><?php echo e($invoices->sent_percentage); ?>%</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Total Pending Order')); ?></strong></div>
                        <div class="count-number employee-count"><?php echo e($orderResult->totalPendingOrder); ?></div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Total Completed Order')); ?></strong></div>
                        <div class="count-number employee-count"><?php echo e($orderResult->totalCompletedOrder); ?></div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text"><?php echo e(trans('file.Total Canceled Order')); ?></strong></div>
                        <div class="count-number employee-count"><?php echo e($orderResult->totalCanceledOrder); ?></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/Modules/CRM/resources/views/client/overview.blade.php ENDPATH**/ ?>