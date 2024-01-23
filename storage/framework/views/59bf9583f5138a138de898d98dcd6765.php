<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3><?php echo e(__('file.Process Order')); ?></h3></div>
    </div>
</div>

<div class="container">
    <div class="card">
        <h6 class="card-header">You are about to create the order. Please check details before submitting.</h6>

        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <thead>
                    <tr>
                        <th><?php echo e(trans('file.Item')); ?></th>
                        <th><?php echo e(trans('file.Quantity')); ?></th>
                        <th><?php echo e(trans('file.Rate')); ?></th>
                        <th><?php echo e(trans('file.Sub-Total')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sessionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->title); ?></td>
                            <td>
                                <button data-id="<?php echo e($item->id); ?>" class="quantityDecrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                    <i class="fa fa-minus"></i>
                                </button>
                                &nbsp; <span class="quantity">1</span> &nbsp;
                                
                                <button data-id="<?php echo e($item->id); ?>" class="quantityIncrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                            <td class="rate"><?php echo e($item->rate); ?></td>
                            <td class="subtotal"><?php echo e(number_format($item->rate * 1, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th colspan="2"></th>
                        <th> Total : </th>
                        <th id="totalAmount"> <?php echo e(number_format($totalAmount, 2)); ?></th>
                    </tr>
                </tbody>
            </table>
        </div>

        <label class="text-bold ml-2"><strong><?php echo e(trans('file.Clients')); ?></label>
        <select name="client_id"
            class="ml-2 form-control selectpicker"
            data-live-search="true" data-live-search-style="contains"
            title="<?php echo e(__('Selecting',['key'=>trans('file.Client')])); ?>...">
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item->id); ?>"><?php echo e($item->first_name.' '.$item->last_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>


        <button class="ml-2 mt-4 mb-5 btn btn-success"><?php echo app('translator')->get('file.Place Order'); ?></button>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

    $(document).on('click', '.quantityDecrement', function() {
        calculateAndDisplay('decrement', this);
    });

    $(document).on('click', '.quantityIncrement', function() {
        calculateAndDisplay('increment', this);
    });


    let calculateAndDisplay = (type, clickedElement) => {

        var quantity = parseInt($(clickedElement).siblings('span').text());

        if (type==='increment') {
            var totalQuantity = quantity + 1;
        }else {
            var totalQuantity = quantity - 1;

            if (totalQuantity < 1) {
                return;
            }
        }

        let rateElement = $(clickedElement).closest('tr').find('.rate');
        let rateValue = parseFloat(rateElement.text());

        let subtotal = totalQuantity * rateValue;

        let prevTotalAmount = parseFloat($('#totalAmount').text());
        let newTotalAmount;

        if (type =='increment') {
            newTotalAmount = prevTotalAmount + rateValue;
        } else {
            newTotalAmount = prevTotalAmount - rateValue;
        }

        $(clickedElement).siblings('span').text(totalQuantity);
        $(clickedElement).closest('tr').find('.subtotal').text(subtotal.toFixed(2));
        $('#totalAmount').text(newTotalAmount.toFixed(2));
        // console.log('subtotal', subtotal);
        // console.log('prevTotalAmount :',prevTotalAmount);
        // console.log('newTotalAmount :',newTotalAmount);
    }


</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/crm/sale_section/store/process_order.blade.php ENDPATH**/ ?>