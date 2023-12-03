
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> <?php echo e(__('file.Edit Lead')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" id="updateForm">
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <input type="hidden" id="modelId">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Company')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="company_id" id="companyIdEdit"
                                        class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...">
                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Owner')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="employee_id" id="employeeIdEdit" class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains" data-first_name="first_name"
                                        data-last_name="last_name" title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>'>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Status')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="status" id="statusEdit" class="form-control" title="<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...">
                                        <option value="new">New</option>
                                        <option value="qualified">Qualified</option>
                                        <option value="discussion">Discussion</option>
                                        <option value="negotiation">Negotiation</option>
                                        <option value="won">Won</option>
                                        <option value="lost">Lost</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong><?php echo e(trans('file.Country')); ?> <span class="text-danger">*</span></strong></label>
                                <select name="country_id" id="countryId"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="<?php echo e(__('Selecting',['key'=>trans('file.Country')])); ?>...">
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'City',
                            'fieldType' => 'text',
                            'nameData' => 'city',
                            'placeholderData' => 'Chittagong',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'State',
                            'fieldType' => 'text',
                            'nameData' => 'state',
                            'placeholderData' => 'XYZ',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Zip',
                            'fieldType' => 'text',
                            'nameData' => 'zip',
                            'placeholderData' => '4330',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Address',
                            'fieldType' => 'textarea',
                            'nameData' => 'address',
                            'placeholderData' => 'eg: Muradpur, Chittagong, Bangladesh',
                            'isRequired' => true,
                            'idData' => 'addressEdit'
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
                            'labelName' => 'Website',
                            'fieldType' => 'text',
                            'nameData' => 'website',
                            'placeholderData' => 'https://www.linkedin.com/',
                            'isRequired' => false,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'VAT Number',
                            'fieldType' => 'text',
                            'nameData' => 'vat_number',
                            'placeholderData' => '123456',
                            'isRequired' => true,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'GST Number',
                            'fieldType' => 'text',
                            'nameData' => 'gst_number',
                            'placeholderData' => '987654',
                            'isRequired' => false,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submitButton"><?php echo app('translator')->get('file.Update'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/crm/lead_section/lead/edit-modal.blade.php ENDPATH**/ ?>