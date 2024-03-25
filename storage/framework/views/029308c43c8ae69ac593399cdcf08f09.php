
<?php $__env->startSection('content'); ?>

    <section>

    <?php echo $__env->make('shared.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('shared.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Content -->
        <div class="container-fluid">
            <div class="row">

                <div class="col-3 col-md-2 mb-3">
                    <img src=<?php echo e(URL::to('/uploads/profile_photos')); ?>/<?php echo e($user->profile_photo ?? 'avatar.jpg'); ?>  width='150'
                         class='rounded-circle'>
                </div>

                <div class="col-9 col-md-10 mb-3">
                    <h4 class="font-weight-bold"><?php echo e($client->first_name); ?>  <?php echo e($client->last_name); ?> <span class="text-muted">(<?php echo e($user->username); ?>)</span>
                    </h4>
                    <div class="text-muted mb-2"><?php echo e(trans('file.Company')); ?>: <?php echo e($client->company_name); ?></div>
                    <p class="text-muted pb-0-5"><?php echo e(__('Last Login')); ?>: <?php echo e($user->last_login_date); ?></p>

                    <a href="<?php echo e(route('clientProfile')); ?>">
                        <button class="btn btn-primary btn-block text-uppercase" id="my_profile"><i
                                    class="ion-person"></i><?php echo e(trans('file.Profile')); ?></button>
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid dashboard-counts">
            <div class="row">

                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="<?php echo e(route('clientInvoicePaid')); ?>">
                                <div class="name"><strong class="purple-text"><?php echo e(__('Paid Invoice')); ?></strong></div>
                                <div class="count-number award_count"><?php echo e($paid_invoice_count); ?></div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="<?php echo e(route('clientInvoice')); ?>">
                                <div class="name"><strong class="green-text"><?php echo e(__('Unpaid Invoice')); ?></strong></div>
                                <div class="count-number award_count"><?php echo e($unpaid_invoice_count); ?></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="<?php echo e(route('clientProjectStatus')); ?>?status=completed">
                                <div class="name"><strong class="blue-text"><?php echo e(__('Completed Projects')); ?></strong>
                                </div>
                                <div class="count-number award_count"><?php echo e($completed_project_count); ?></div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 mt-3">
                    <div class="wrapper count-title text-center">
                        <div>
                            <a href="<?php echo e(route('clientProjectStatus')); ?>?status=in_progress">
                                <div class="name"><strong class="orange-text"><?php echo e(__('In Progress Projects')); ?></strong>
                                </div>
                                <div class="count-number award_count"><?php echo e($in_progress_project_count); ?></div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="wrapper count-title text-center">
                        <div class="ion ion-information display-4 text-warning"></div>
                        <div>
                            <a href="<?php echo e(route('clientInvoicePaid')); ?>">
                                <div class="name"><strong class="green-text"><?php echo e(__('Paid Amount')); ?></strong></div>
                                <div class="count-number award_count"><?php echo e($invoice_paid_amount); ?></div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mt-3">
                    <div class="wrapper count-title text-center">
                        <div class="ion ion-information display-4 text-warning"></div>
                        <div>
                            <a href="<?php echo e(route('clientInvoice')); ?>">
                                <div class="name"><strong class="blue-text"><?php echo e(__('Due Amount')); ?></strong></div>
                                <div class="count-number award_count"><?php echo e($invoice_unpaid_amount); ?></div>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/resources/views/dashboard/client_dashboard.blade.php ENDPATH**/ ?>