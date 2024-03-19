
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> <?php echo e(__('file.Add Task')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="<?php echo e(route('lead.task.store', ['lead' => $lead->id])); ?>" id="submitForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Points')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="points" class="form-control" title="<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...">
                                    <option value="1">1 Points</option>
                                    <option value="2">2 Points</option>
                                    <option value="3">3 Points</option>
                                    <option value="4">4 Points</option>
                                    <option value="5">5 Points</option>
                                </select>
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 12,
                            'labelName' => 'Description',
                            'fieldType' => 'textarea',
                            'nameData' => 'description',
                            'placeholderData' => 'Textarea',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Assigned Employee')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="employee_id"
                                        required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...">
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->first_name.' '.$employee->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Collaborators')); ?></strong></label>
                                <select name="collaborator_employee_ids[]"
                                        class="form-control selectpicker" multiple="multiple"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...">
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->first_name.' '.$employee->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Status')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="status" class="form-control" title="<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...">
                                    <option value="To do">To do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Review">Review</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Priority')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="priority" class="form-control" title="<?php echo e(__('Selecting',['key'=>trans('file.Priority')])); ?>...">
                                    <option value="Minor">Minor</option>
                                    <option value="Major">Major</option>
                                    <option value="Critical">Critical</option>
                                    <option value="Blocker">Blocker</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Labels')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="labels" class="form-control selectpicker" title="<?php echo e(__('Selecting',['key'=>trans('file.Labels')])); ?>...">
                                    <option value="Feedback">Feedback</option>
                                    <option value="Bug">Bug</option>
                                    <option value="Enhancement">Enhancement</option>
                                    <option value="Design">Design</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Start Date')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="start_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.End Date')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="end_date">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div><button type="submit" class="btn btn-primary" id="submitButton"><?php echo app('translator')->get('file.Save'); ?></button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peopleprocrm/Modules/CRM/resources/views/lead_section/task/create-modal.blade.php ENDPATH**/ ?>