<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="d-flex justify-content-between">
            <div class="card-header"><h3><?php echo e(__('file.Store')); ?></h3></div>
            <?php if($totalAmount > 0): ?>
                <div class="card-header">
                    <a href="<?php echo e(route('client.store.chekout')); ?>" class="btn btn-info">
                    Checkout
                    <?php if(config('variable.currency_format') =='suffix'): ?>
                        ( <?php echo e(number_format($totalAmount, 2)); ?> <?php echo e(config('variable.currency')); ?> )
                    <?php else: ?>
                        ( <?php echo e(config('variable.currency')); ?> <?php echo e(number_format($totalAmount, 2)); ?> )
                    <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
    </div>
</div>


<div class="container">
    <div class="row">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <form action="<?php echo e(route('store.addToCart', $item->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="card" style="width: 18rem;">
                        <?php if($item->image): ?>
                            <img class="card-img-top" src="<?php echo e(asset('uploads/crm/items/'.$item->image)); ?>" alt="Card image cap" width="300px" height="200px" >
                        <?php else: ?>
                            <img class="card-img-top" src="<?php echo e(asset('logo/empty.jpg')); ?>" alt="Card image cap" width="300px" height="200px" >
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($item->title); ?></h5>
                            <p class="card-text">
                                <?php if(config('variable.currency_format') =='suffix'): ?>
                                    <span class="text-danger" style="font-family: DejaVu Sans; sans-serif;"><?php echo e($item->rate); ?><?php echo e(config('variable.currency')); ?></span>
                                <?php else: ?>
                                    <span class="text-danger" style="font-family: DejaVu Sans; sans-serif;"><?php echo e(config('variable.currency')); ?><?php echo e($item->rate); ?></span>
                                <?php endif; ?>
                                / <small><?php echo e($item->unit_type); ?></small></p>
                            <p class="card-text"><?php echo e($item->description); ?></p>

                            <?php if($sessionItemsIds && in_array($item->id, $sessionItemsIds)): ?>
                                <button disabled class="btn btn-success text-center">Added</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary text-center">Add to Cart</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/client/store/index.blade.php ENDPATH**/ ?>