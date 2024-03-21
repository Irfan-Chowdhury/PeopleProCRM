<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> <?php echo e(__('file.Edit Contract')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="modelId" name="model_id">

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Title',
                            'fieldType' => 'text',
                            'nameData' => 'title',
                            'placeholderData' => 'Title',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Contract Date')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="start_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Valid Until')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="end_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Project')); ?> </strong><span class="text-danger">*</span></label>
                                <select name="project_id"
                                        id="projectIdEdit"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Tax')])); ?>...">
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e($project->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Client/Lead')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="hidden" name="candidate_type">
                                <input type="hidden" name="candidate_id">
                                <select name="candidate"
                                        required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Client/Lead')])); ?>...">
                                    <?php $__currentLoopData = $clientsOrLeads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value->id); ?>" data-type="<?php echo e($value->type); ?>" data-id="<?php echo e($value->id); ?>"> <?php echo e(ucfirst($value->type).' : '.$value->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Tax')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="tax_type_id"
                                    class="form-control selectpicker"
                                    data-live-search="true" data-live-search-style="contains"
                                    title="<?php echo e(__('Selecting',['key'=>trans('file.Tax')])); ?>...">
                                    <?php $__currentLoopData = $taxTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tax->id); ?>"><?php echo e($tax->name); ?> (<?php echo e($tax->rate); ?>%)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 12,
                            'labelName' => 'Note',
                            'fieldType' => 'textarea',
                            'nameData' => 'note',
                            'placeholderData' => 'Textarea',
                            'isRequired' => false,
                            'idData' => 'noteEdit'
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="submitButton"><?php echo app('translator')->get('file.Update'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/sale_section/contracts/edit-modal.blade.php ENDPATH**/ ?>