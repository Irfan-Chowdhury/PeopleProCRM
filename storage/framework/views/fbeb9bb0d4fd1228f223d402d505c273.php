<?php $__env->startSection('body'); ?>

<?php echo $__env->make('includes.session_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
?>

<div class="container-fluid mt-4">
    <div class="card">

        <div class="card-header">
            <h3 class="card-title"><?php echo e(__('Add Language')); ?></h3>
        </div>
        <div class="card-body p-4">
            <form action="<?php echo e(route('languages.store')); ?>" method="POST">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <label><?php echo e(__('New Language Name')); ?></label>
                <input type="text" name="name" class="form-control">
                <label><?php echo e(__('New Language Short Key')); ?></label>
                <input type="text" name="locale" class="form-control" placeholder="example: 'en', 'es' etc.">

                <button class="btn btn-primary mt-3">
                    <?php echo e(__('Save')); ?>

                </button>

            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('translation::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/resources/views/vendor/translation/languages/create.blade.php ENDPATH**/ ?>