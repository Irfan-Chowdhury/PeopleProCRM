
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> <?php echo e(__('file.Add Contact')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="<?php echo e(route('lead.contact.store', ['lead' => $lead->id])); ?>" id="submitForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'First Name',
                            'fieldType' => 'text',
                            'nameData' => 'first_name',
                            'placeholderData' => 'Irfan',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Last Name',
                            'fieldType' => 'text',
                            'nameData' => 'last_name',
                            'placeholderData' => 'Chowdhhury',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Email',
                            'fieldType' => 'text',
                            'nameData' => 'email',
                            'placeholderData' => 'irfan@gmail.com',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Phone',
                            'fieldType' => 'text',
                            'nameData' => 'phone',
                            'placeholderData' => '+8801234567890',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Address',
                            'fieldType' => 'textarea',
                            'nameData' => 'address',
                            'placeholderData' => 'eg: Muradpur, Chittagong, Bangladesh',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Job Title',
                            'fieldType' => 'text',
                            'nameData' => 'job_title',
                            'placeholderData' => 'eg: Software Engineer',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Image',
                            'fieldType' => 'file',
                            'nameData' => 'image',
                            'placeholderData' => '',
                            'isRequired' => false,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Gender')); ?> <span class="text-danger">*</span></strong></label>
                                <input type="radio" name="gender" value="male" class="ml-2"> Male
                                <input type="radio" name="gender" value="female" class="ml-2"> Female
                                <input type="radio" name="gender" value="other" class="ml-2"> Other
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Primary Contact',
                            'fieldType' => 'checkbox',
                            'nameData' => 'is_primary_contact',
                            'placeholderData' => '',
                            'isRequired' => false,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submitButton"><?php echo app('translator')->get('file.Save'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/lead_section/contact/create-modal.blade.php ENDPATH**/ ?>