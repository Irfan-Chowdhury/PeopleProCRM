<!--Edit Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> <?php echo e(__('file.Edit Item')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="modelId">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Item')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="item_id"
                                        required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Item')])); ?>...">
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Quantity',
                            'fieldType' => 'text',
                            'nameData' => 'quantity',
                            'placeholderData' => 'Ex: 10',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Unit Type')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" readonly name="unit_type" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Rate')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" readonly name="rate" class="form-control">
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 12,
                            'labelName' => 'Description',
                            'fieldType' => 'textarea',
                            'nameData' => 'description',
                            'placeholderData' => 'Description',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="updateButton"><?php echo app('translator')->get('file.Update'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/sale_section/contracts/contract_item/edit-modal.blade.php ENDPATH**/ ?>