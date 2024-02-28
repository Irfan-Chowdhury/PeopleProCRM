<?php $__env->startSection('title','Admin | New Release Version'); ?>
<?php $__env->startSection('content'); ?>

    <div class="mt-3 mb-3" id="errorMessage"></div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" >
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Cuurent Version -->
    <?php if(!$alertVersionUpgradeEnable): ?>
        <section id="oldVersionSection" class="container mt-5 text-center">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center text-info">Your current version is <span><?php echo e(env('VERSION')); ?></span></h4>
                        <p>Please wait for upcoming version</p>
                    </div>
                </div>
        </section>
    <?php else: ?>
        <!-- For New Version -->
        <section id="newVersionSection" class="container mt-5 text-center">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center text-success"> A new version <b><?php echo e($newVersion); ?></b> has been released.</h4>
                    <p>Before upgrading, we highly recomended you to keep a backup of your current script and database.</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="text-left p-4">New Change Log</h4>
                    <ul class="list-group text-left ml-4" id="logUL">
                        <?php if(isset($getVersionUpgradeDetails->logs)): ?>
                            <?php $__currentLoopData = $getVersionUpgradeDetails->logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p> <?php echo e($item->text); ?> </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p class="text-danger"> No Data Found </p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3 mb-3">
                <div id="spinner" class="d-none spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <form action="<?php echo e(route('version-upgrade')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <button type="submit" class="mt-5 mb-5 btn btn-primary btn-lg">Upgrade</button>
            </form>

        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/version_upgrade/index.blade.php ENDPATH**/ ?>