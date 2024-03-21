<!--Create Modal -->
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
                <input type="hidden" id="modelId" name="model_id">

                <div class="modal-body">
                    <div class="row">

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Title',
                            'fieldType' => 'text',
                            'nameData' => 'title',
                            'placeholderData' => 'Title',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Description',
                            'fieldType' => 'textarea',
                            'nameData' => 'description',
                            'placeholderData' => 'Description',
                            'isRequired' => false,
                            'idData' => 'descriptionEdit'
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Category')); ?> </strong><span class="text-danger">*</span></label>
                                <select name="item_category_id"
                                        id="itemCategoryId"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Category')])); ?>...">
                                    <?php $__currentLoopData = $itemCategogries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>


                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Unit Type',
                            'fieldType' => 'text',
                            'nameData' => 'unit_type',
                            'placeholderData' => 'Unit Type (Ex: hours, pc, etc.)',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Rate',
                            'fieldType' => 'number',
                            'nameData' => 'rate',
                            'placeholderData' => 'Rate',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="col-md-6">
                            <div class="form-group mt-4">
                                <input type="checkbox" name="is_client_visible">
                                <label class="ml-2 text-bold"><strong><?php echo e(trans('file.Show in Client portal')); ?></strong></label>
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Image',
                            'fieldType' => 'file',
                            'nameData' => 'image',
                            'placeholderData' => null,
                            'isRequired' => false,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div><button type="submit" class="btn btn-primary" id="updateButton"><?php echo app('translator')->get('file.Update'); ?></button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/sale_section/items/edit-modal.blade.php ENDPATH**/ ?>