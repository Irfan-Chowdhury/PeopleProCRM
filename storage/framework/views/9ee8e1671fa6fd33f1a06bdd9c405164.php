<?php $__env->startSection('lead_details'); ?>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3><?php echo e(__('file.Lead Info')); ?></h3>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Company</th>
                            <td><?php echo e($lead->company->company_name); ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?php echo e(ucfirst($lead->status)); ?></td>
                        </tr>
                        <tr>
                            <th>Owner</th>
                            <td><?php echo e($lead->owner->first_name.' '.$lead->owner->last_name); ?></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td><?php echo e($lead->country->name); ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?php echo e($lead->city); ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo e($lead->state); ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo e($lead->zip); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo e($lead->address); ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?php echo e($lead->phone); ?></td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td><?php echo e($lead->website); ?></td>
                        </tr>
                        <tr>
                            <th>Vat Number</th>
                            <td><?php echo e($lead->vat_number); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('crm::lead_section.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/Modules/CRM/resources/views/lead_section/lead_info/show.blade.php ENDPATH**/ ?>