
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> <?php echo e(__('file.Add Subscription')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="submitForm" action="<?php echo e(route('subscription.store')); ?>">
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
                                <label class="text-bold"><strong><?php echo e(trans('file.First Billing Date')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="first_billing_date">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Client')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="client_id"
                                        class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Client')])); ?>...">
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($client->id); ?>"><?php echo e($client->first_name.' '.$client->last_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Tax')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="tax_type_id"
                                        class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Tax')])); ?>...">
                                    <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($taxe->id); ?>"><?php echo e($taxe->name); ?> (<?php echo e($taxe->rate); ?>%)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Repeat Type')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="repeat_type" class="form-control" title="<?php echo e(__('Selecting',['key'=>trans('file.Repeat Type')])); ?>...">
                                        <option value="day">Day</option>
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                </select>
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Note',
                            'fieldType' => 'textarea',
                            'nameData' => 'note',
                            'placeholderData' => 'Note',
                            'isRequired' => false,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div><button type="submit" class="btn btn-primary" id="submitButton"><?php echo app('translator')->get('file.Save'); ?></button></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/subscription_section/subscription/create-modal.blade.php ENDPATH**/ ?>