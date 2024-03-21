<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3><?php echo e(__('file.Process Order')); ?></h3></div>
    </div>
</div>


<div class="container">
    <div class="card">
        <h6 class="card-header">You are about to create the order. Please check details before submitting.</h6>

        <form action="<?php echo e(route('store.processOrder')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="totalInput" name="total" value="<?php echo e($totalAmount); ?>">
            <input type="hidden" id="taxInput" name="tax" value="0">

            <div class="table-responsive">
                <table id="dataListTable" class="table ">
                    <thead>
                        <tr>
                            <th><?php echo e(trans('file.Item')); ?></th>
                            <th><?php echo e(trans('file.Quantity')); ?></th>
                            <th><?php echo e(trans('file.Rate')); ?></th>
                            <th><?php echo e(trans('file.Total')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $sessionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" class="itemId" name="item_id[]" value="<?php echo e($item->id); ?>">
                            <input type="hidden" class="finalQuantity_<?php echo e($item->id); ?>" name="quantity[]" value="1">
                            <input type="hidden" name="rate[]" value="<?php echo e($item->rate); ?>">
                            <input type="hidden" class="subtotal_<?php echo e($item->id); ?>" name="subtotal[]" value="<?php echo e($item->rate); ?>">

                            <tr>
                                <td><?php echo e($item->title); ?></td>
                                <td>
                                    <button data-id="<?php echo e($item->id); ?>" class="quantityDecrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    &nbsp; <span class="quantity">1</span> &nbsp;
                                    <!-- / <small><?php echo e(strtoupper($item->unit_type)); ?></small> -->
                                    <button data-id="<?php echo e($item->id); ?>" class="quantityIncrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td class="rate"><?php echo e($item->rate); ?></td>
                                <td class="subtotal"><?php echo e(number_format($item->rate * 1, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr></tr>
                        <tr>
                            <th colspan="2"></th>
                            <th> Sub Total : </th>
                            <th id="subTotalAmount"> <?php echo e(number_format($totalAmount, 2)); ?></th>
                        </tr>
                        <tr>
                            <th colspan="2"></th>
                            <th> Total Amount: </th>
                            <th id="totalAmount"> <?php echo e(number_format($totalAmount, 2)); ?></th>
                        </tr>
                    </tbody>
                </table>

            </div>


            <div class="row">
                <div class="col-md-6">
                    <label class="text-bold ml-2"><strong><?php echo e(trans('file.Clients')); ?> <span class="text-danger"><b>*</b></span></label>
                    <select name="client_id"
                        required
                        class="ml-2 form-control selectpicker"
                        data-live-search="true" data-live-search-style="contains"
                        title="<?php echo e(__('Selecting',['key'=>trans('file.Client')])); ?>...">
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->first_name.' '.$item->last_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="text-bold ml-2"><strong><?php echo e(trans('file.Tax')); ?> <span class="text-danger"><b>*</b></span></label>
                    <select name="tax_type_id"
                        id="taxType"
                        required
                        class="ml-2 selectpicker"
                        data-live-search="true" data-live-search-style="contains"
                        title="<?php echo e(__('Selecting',['key'=>trans('file.Tax')])); ?>...">
                        <?php $__currentLoopData = $taxTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tax_type->rate); ?>"><?php echo e($tax_type->name); ?>(<?php echo e($tax_type->rate); ?>%)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="ml-2 mt-4 mb-5 btn btn-success"><?php echo app('translator')->get('file.Place Order'); ?></button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

    $(document).on('click', '.quantityDecrement', function(e) {
        e.preventDefault();
        calculateAndDisplay('decrement', this);
    });

    $(document).on('click', '.quantityIncrement', function(e) {
        e.preventDefault();
        calculateAndDisplay('increment', this);
    });


    $('#taxType').change(function () {
        let taxRate = parseInt($(this).val());
        let totalAmount = parseFloat($('#subTotalAmount').text());
        let TaxOnAmount = (taxRate / 100 ) * totalAmount;
        let totalAmountIncludingTax = totalAmount + TaxOnAmount;

        if (TaxOnAmount > 0) {
            $('#totalAmount').empty().text(totalAmountIncludingTax.toFixed(2)+" (Including Tax)");
        }else{
            $('#totalAmount').empty().text(totalAmountIncludingTax.toFixed(2));
        }
        $('#taxInput').val(TaxOnAmount.toFixed(2));
        $('#totalInput').text(totalAmountIncludingTax.toFixed(2));

    });



    let calculateAndDisplay = (type, clickedElement) => {

        var rowId = $(clickedElement).data('id');
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

        let prevSubTotalAmount = parseFloat($('#subTotalAmount').text());

        let taxAmount = 0;
        if ($("select[name='tax_type_id'] option:selected").length > 0) {
            let selectedValue = $("select[name='tax_type_id']").val();
            if (!isNaN(parseInt(selectedValue))) {
                taxAmount = parseInt(selectedValue);
            }
        }

        let newTotalAmount;
        if (type =='increment') {
            newSubTotalAmount = prevSubTotalAmount + rateValue;
        } else {
            newSubTotalAmount = prevSubTotalAmount - rateValue;
        }

        TotalAmountWithTax = newSubTotalAmount + (newSubTotalAmount * taxAmount) / 100;

        $(clickedElement).siblings('span').text(totalQuantity);
        $(clickedElement).closest('tbody').find('.finalQuantity_'+rowId).val(totalQuantity);

        $(clickedElement).closest('tr').find('.subtotal').text(subtotal.toFixed(2));
        $(clickedElement).closest('tbody').find('.subtotal_'+rowId).val(subtotal.toFixed(2));

        $('#subTotalAmount').text(newSubTotalAmount.toFixed(2));
        $('#totalAmount').text(TotalAmountWithTax.toFixed(2));
        $('#totalInput').val(TotalAmountWithTax.toFixed(2));
    }


</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/sale_section/store/chekout.blade.php ENDPATH**/ ?>