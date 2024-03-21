<?php $__env->startSection('content'); ?>

<section>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <span id="form_result"></span>
                <h3 class="card-title"> <?php echo e(__('Create Invoice')); ?> </h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('invoices.store')); ?>" name="create_invoice" id="create_invoice" autocomplete="off" class="form" method="post" accept-charset="utf-8">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="invoice_number"><?php echo e(__('Invoice Number')); ?></label>
                                <input class="form-control" placeholder="<?php echo e(__('Invoice Number')); ?>" name="invoice_number" type="text" value="<?php echo e($invoice_number); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="project"><?php echo e(trans('file.Project')); ?></label>
                                <select name="project_id" id="project_id" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Project')])); ?>...'>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e($project->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="invoice_date"><?php echo e(__('Invoice Date')); ?></label>
                                <input class="form-control date" required placeholder="Invoice Date"  name="invoice_date" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="invoice_due_date"><?php echo e(__('Due Date')); ?></label>
                                <input class="form-control date" required placeholder="Due Date"  name="invoice_due_date" type="text" value="">
                            </div>
                        </div>
                    </div>
                    <hr>

                    


                    <div id="item-list">
                        <div id="1" class="item">
                            <div class="row">
                                <div class="form-group mb-1 col-sm-12 col-md-3">
                                    <label for="item_name"><?php echo e(trans('file.Item')); ?></label>
                                    <br>
                                    <select name="item_id[]" id="item_id" class="invoiceItemId form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Item')])); ?>...'>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-1">
                                    <label for="qty_hrs" class="cursor-pointer"><?php echo e(trans('file.Qty')); ?></label>
                                    <br>
                                    <input type="number" class="form-control qty_hrs calc" required name="qty_hrs[]" value="1" min="1">
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label for="unit_price"><?php echo e(__('Unit Price')); ?></label>
                                    <br>
                                    <input readonly class="form-control unit_price calc" name="unit_price[]" value="0" />
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label for="tax_type"><?php echo e(__('Tax Type')); ?></label>
                                    <br>
                                    <select name="tax_type_id[]" required class="form-control tax_type" data-live-search="true" data-live-search-style="contains" title='<?php echo e(__('Tax Type')); ?>'>
                                        <option value=""><?php echo e(__('Tax Type')); ?></option>
                                    <?php $__currentLoopData = $tax_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($tax_type->type == 'fixed'): ?>
                                                <option value="<?php echo e($tax_type->rate); ?>"><?php echo e($tax_type->name); ?>(<?php echo e($tax_type->rate); ?>%)</option>
                                            <?php else: ?>
                                                <option value="<?php echo e($tax_type->rate); ?>"><?php echo e($tax_type->name); ?>(<?php echo e($tax_type->rate); ?>%)</option>
                                            <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-1">
                                    <label for="tax_type"><?php echo e(__('Tax Rate')); ?></label>
                                    <br>
                                    <input type="text" class="form-control tax_amount" name="tax_amount[]" value="0"  readonly="readonly" />
                                </div>
                                <div class="form-group mb-1 col-sm-12 col-md-2">
                                    <label for="profession"><?php echo e(__('Sub Total')); ?></label>
                                    <input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />
                                    <!-- <br>-->
                                    <p class="form-control-static d-none"><span class="amount-html">0</span></p>
                                </div>
                                <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="form-group overflow-hidden1">
                        <div class="col-xs-12">
                            <button type="button" data-repeater-create="" class="btn btn-primary" id="add-invoice-item"> <i class="fa fa-plus"></i> <?php echo e(__('Add Item')); ?></button>
                        </div>
                    </div>
                    <input type="hidden" class="items-sub-total" name="items_sub_total" value="0" />
                    <input type="hidden" class="items-tax-total" name="items_tax_total" value="0" />
                    <div class="row">
                        <div class="col-md-7 col-sm-12 text-xs-center text-md-left">&nbsp; </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td><?php echo e(__('Sub Total')); ?></td>
                                        <td class="text-xs-right"><span id="sub_total" class="sub_total">0</span></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo e(__('Tax Rate')); ?></td>
                                        <td class="text-xs-right"><span id="total_tax" class="total_tax">0</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td><strong><?php echo e(__('Discount Type')); ?></strong></td>
                                                    <td><strong><?php echo e(trans('file.Discount')); ?></strong></td>
                                                    <td><strong><?php echo e(__('Discount Amount')); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <select name="discount_type" class="form-control discount_type">
                                                                <option value="0"><?php echo e(trans('file.Flat')); ?></option>
                                                                <option value="1"><?php echo e(trans('file.Percent')); ?></option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" name="discount_figure" class="form-control discount_figure text-right" value="0" required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" readonly="" name="discount_amount" value="0" class="discount_amount form-control text-right">
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table></td>
                                    </tr>
                                    <input type="hidden" class="grand_total" id="grand_total_form" name="grand_total" value="0" />
                                    <tr>
                                        <td><?php echo e(__('Grand Total')); ?></td>
                                        <td class="text-xs-right"><span id="grand_total" class="grand_total">0</span></td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 mb-2 file-repeaters"> </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="invoice_note"><?php echo e(__('Invoice Note')); ?></label>
                            <textarea name="invoice_note" class="form-control"></textarea>
                        </div>
                    </div>

                    <div id="invoice-footer">
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-md-5 col-sm-12 text-xs-center">
                                <button type="submit" name="invoice_submit" class="btn btn-primary pull-right my-1 mr-3"><i class="fa fa fa-check-square-o"></i> <?php echo e(__('Submit Invoice')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>


<?php
$itemOptions = '';
foreach($items as $item) {
    $itemOptions .= '<option value="' . $item->id . '">' . $item->title . '</option>';
}
?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function($) {
        "use strict";

        let date = $('.date');
        date.datepicker({
            format: '<?php echo e(env('Date_Format_JS')); ?>',
            autoclose: true,
            todayHighlight: true
        });

        var items = <?php echo $items; ?>;

        $(document).on('click', '#add-invoice-item', function(){
            var item_id = parseInt($('#item-list .item:last').attr('id'))+1;

            let html =
            `<div id="item-list">
                <div id="${item_id}" class="item">
                    <div class="row">
                        <div class="form-group mb-1 col-sm-12 col-md-3">
                            <label for="item_name"><?php echo e(trans('file.Item')); ?></label>
                            <br>
                            <select name="item_id[]" id="item_id" class="itemId form-control item_id">
                                <option value=""><?php echo e(__('Select Item')); ?></option>
                            </select>
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-1">
                            <label for="qty_hrs" class="cursor-pointer"><?php echo e(trans('file.Qty')); ?></label>
                            <br>
                            <input type="number" class="form-control qty_hrs calc" required name="qty_hrs[]" value="1" min="1">
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                            <label for="unit_price"><?php echo e(__('Unit Price')); ?></label>
                            <br>
                            <input readonly class="form-control unit_price calc" required name="unit_price[]" value="0" />
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                            <label for="tax_type"><?php echo e(__('Tax Type')); ?></label>
                            <br>
                            <select name="tax_type_id[]" required class="form-control tax_type" data-live-search="true" data-live-search-style="contains" title='<?php echo e(__('Tax Type')); ?>'>
                                <option value=""><?php echo e(__('Tax Type')); ?></option>
                            <?php $__currentLoopData = $tax_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($tax_type->type == 'fixed'): ?>
                                        <option value="<?php echo e($tax_type->rate); ?>"><?php echo e($tax_type->name); ?>(<?php echo e($tax_type->rate); ?>%)</option>
                                    <?php else: ?>
                                        <option value="<?php echo e($tax_type->rate); ?>"><?php echo e($tax_type->name); ?>(<?php echo e($tax_type->rate); ?>%)</option>
                                    <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-1">
                            <label for="tax_type"><?php echo e(__('Tax Rate')); ?></label>
                            <br>
                            <input type="text" class="form-control tax_amount" name="tax_amount[]" value="0"  readonly="readonly" />
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                            <label for="profession"><?php echo e(__('Sub Total')); ?></label>
                            <input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />
                            <p class="form-control-static d-none"><span class="amount-html">0</span></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">

                        </div>
                    </div>
                </div>
            </div>`;
            $('#item-list').append(html);

            items.forEach(function(item) {
                $('#item-list #'+item_id+' .item_id').append(
                    `<option value="${item.id}">${item.title}</option>`
                );
            });

            // var tax_type = <?php echo json_encode( $tax_types ) ?>;
            var tax_type = <?php echo json_encode($tax_types); ?>;
            tax_type.forEach(function(v) {
                if(v.type == 'fixed') {
                    $('#item-list #'+item_id+' .tax-types').append("<option value='$"+v.rate+"'>"+v.name+" ($"+v.rate+")</option>");
                } else {
                    $('#item-list #'+item_id+' .tax-types').append("<option value='"+v.rate+"'>"+v.name+" ("+v.rate+"%)</option>");
                }
            });
        });


        $('.invoiceItemId').change(function () {
            let itemId = parseInt($(this).val());
            let rowId = parseInt($(this).closest('.item').attr('id'));
            let item = items.find(function(item) {
                return parseInt(item.id) === itemId;
            });
            let itemRate = item ? item.rate : 0;
            $('#'+rowId+' .unit_price').val(itemRate);
        });


        $(document).on('change', '.itemId', function() {
            let itemId = parseInt($(this).val());
            let rowId = parseInt($(this).closest('.item').attr('id'));
            let item = items.find(function(item) {
                return parseInt(item.id) === itemId;
            });

            let itemRate = item ? item.rate : 0;
            $('#'+rowId+' .unit_price').val(itemRate);
        });







        $(document).on('click', '.remove-invoice-item', function(){
            let item_id = $(this).parent().parent().parent().attr('id');
            let rmv_sub_total = Number($('#'+item_id+' .sub-total-item').val());
            let all_total =  Number($('#sub_total').text());
            let new_sub_total = all_total - rmv_sub_total;
            let all_tax = Number($('#total_tax').text());
            let rmv_tax =  Number($('#'+item_id+' .tax_amount').val());
            let new_tax = all_tax - rmv_tax;
            $('#sub_total').html(new_sub_total);
            $('#total_tax').html(new_tax);
            $('#grand_total').html(new_sub_total);
            $('#'+item_id).remove();
        });

        $(document).on('keyup', '.calc', function(){
            var k = $(this).parent().parent().parent().attr('id');
            var qty = $('#'+k+' .qty_hrs').val();
            var unit_price = $('#'+k+' .unit_price').val();
            var tax_rate = $('#'+k+' .tax_type').val();

            if ($(this).val() !== '') {
                if (tax_rate !== '') {
                    if (tax_rate.indexOf("$") >= 0) {
                        tax_rate = Number(tax_rate.substr(1));

                        var sub_total = ((qty*unit_price) + tax_rate);

                        $('#'+k+' .sub-total-item').val(sub_total);

                        var tax_amount = tax_rate;

                        $('#'+k+' .tax_amount').val(tax_amount);
                    } else {
                        var sub_total = ((qty*unit_price) + (((qty*unit_price)*tax_rate)/100));

                        $('#'+k+' .sub-total-item').val(sub_total);

                        var tax_amount = (((qty*unit_price)*tax_rate)/100);

                        $('#'+k+' .tax_amount').val(tax_amount);
                    }
                } else {
                    var sub_total = (qty*unit_price);

                    $('#'+k+' .sub-total-item').val(sub_total);
                }
            }

            var sum = 0;
            $('.sub-total-item').each(function() {
                sum += Number($(this).val());
            });

            $('#sub_total').html(sum);

            var total_tax = 0;
            $('.tax_amount').each(function() {
                total_tax += Number($(this).val());
            });

            $('#total_tax').html(total_tax);
        });

        $(document).on('change', '.tax_type', function(){
            var k = $(this).parent().parent().parent().attr('id');
            var qty = $('#'+k+' .qty_hrs').val();
            var unit_price = $('#'+k+' .unit_price').val();
            var tax_rate = $('#'+k+' .tax_type').val();

            if ($(this).val() !== '') {
                if (tax_rate.indexOf("$") >= 0) {
                    tax_rate = Number(tax_rate.substr(1));

                    var sub_total = ((qty*unit_price) + tax_rate);

                    $('#'+k+' .sub-total-item').val(sub_total);

                    var tax_amount = tax_rate;

                    $('#'+k+' .tax_amount').val(tax_amount);

                } else {
                    var sub_total = ((qty*unit_price) + (((qty*unit_price)*tax_rate)/100));

                    $('#'+k+' .sub-total-item').val(sub_total);

                    var tax_amount = (((qty*unit_price)*tax_rate)/100);

                    $('#'+k+' .tax_amount').val(tax_amount);
                }
            }

            var sum = 0;
            $('.sub-total-item').each(function() {
                sum += Number($(this).val());
            });

            $('#sub_total').html(sum);

            var total_tax = 0;
            $('.tax_amount').each(function() {
                total_tax += Number($(this).val());
            });

            $('#total_tax').html(total_tax);
        });

        $(document).on('keyup', '.discount_figure', function(){

            var discount_type = $('.discount_type').val();

            var discount_figure = $(this).val();

            if (discount_type == '0') {
                $('.discount_amount').val(discount_figure);
            } else {
                var total = Number($('#sub_total').text());

                discount_figure = ((total*discount_figure)/100);
                $('.discount_amount').val(discount_figure);
            }
        });

        $(document).on('change', '.discount_type', function(){
            var total = Number($('#sub_total').text());
            $('.discount_figure').val(0);
            $('.discount_amount').val(0);
            $('#grand_total').html(total);
        });

        // Calculate Grand Total
        $(document).on('change keyup', function(){
            var total = Number($('#sub_total').text());
            var discount_figure =  $('.discount_figure').val();
            if ($('.discount_amount').val() == 0) {
                $('#grand_total').html(total);
            } else {
                if ($('.discount_type').val() == '0') {
                    var grand_total = (total - discount_figure);
                    $('#grand_total').html(grand_total);
                } else {
                    var grand_total = (total - ((total*discount_figure)/100));
                    $('#grand_total').html(grand_total);
                }
            }
        });

        $('#create_invoice').on('submit', function(event) {
            event.preventDefault();
            let sub_total = Number($('#sub_total').text());
            let total_tax =  Number($('#total_tax').text());
            let grand_total = Number($('#grand_total').text());

            $('.items-sub-total').val(sub_total);
            $('.items-tax-total').val(total_tax);
            $('#grand_total_form').val(grand_total);

            $.ajax({
                url: "<?php echo e(route('invoices.store')); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function(){
                            $('#create_invoice')[0].reset();
                            $('#total_tax').html('');
                            $('#sub_total').html('');
                            $('#grand_total').html('');
                            $('.selectpicker').selectpicker('refresh');
                        }, 2000);
                        window.location.href="<?php echo e(route('invoices.create')); ?>";
                    }
                    $('#form_result').html(html).slideDown(100).delay(3000).slideUp(100);

                }
            });
        });
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/resources/views/projects/invoices/create.blade.php ENDPATH**/ ?>