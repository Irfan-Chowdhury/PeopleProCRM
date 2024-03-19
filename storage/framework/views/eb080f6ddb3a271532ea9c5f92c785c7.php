<?php $__env->startSection('content'); ?>

<style>
    .nav-tabs li a {
        padding: 0.75rem 1.25rem;
    }

    .nav-tabs.vertical li {
        border: 1px solid #ddd;
        display: block;
        width: 100%
    }

    .tab-pane {
        padding: 15px 0
    }
</style>

<?php
    $url = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $url);
    $leadId = (int) $urlParts[3];
?>

<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3><?php echo e(__('file.Lead Details')); ?></h3></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('lead.contact.index') ? 'active' : ''); ?>" href="<?php echo e(route('lead.contact.index', $leadId)); ?>"><?php echo e(trans('file.Contact')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('lead.info.show') ? 'active' : ''); ?>" href="<?php echo e(route('lead.info.show', $leadId)); ?>"><?php echo e(trans('file.Lead Info')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('lead.task.index') ? 'active' : ''); ?>" id="set_salary-tab" href="<?php echo e(route('lead.task.index', $leadId)); ?>" role="tab"
                           aria-controls="Set_salary" aria-selected="false"><?php echo e(__('Task')); ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('lead.estimate.index') ? 'active' : ''); ?>"  href="<?php echo e(route('lead.estimate.index', $leadId)); ?>" role="tab"
                            ><?php echo e(trans('file.Estimates')); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('lead.proposals.index') ? 'active' : ''); ?>"  href="<?php echo e(route('lead.proposals.index', $leadId)); ?>" role="tab"
                            ><?php echo e(trans('file.Proposals')); ?>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="employee_project_task-tab" data-toggle="tab"
                           href="#Employee_project_task" role="tab" aria-controls="Employee_project_task"
                           aria-selected="false"> <?php echo e(trans('file.Estimate Request')); ?></a>
                    </li>
                    <li class="nav-item">
                           <a class="nav-link <?php echo e(request()->routeIs('lead.contracts.index') ? 'active' : ''); ?>"  href="<?php echo e(route('lead.contracts.index', $leadId)); ?>" role="tab"><?php echo e(trans('file.Contracts')); ?></a>
                    </li>
                    <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('lead.notes.index') ? 'active' : ''); ?>"  href="<?php echo e(route('lead.notes.index', $leadId)); ?>" role="tab"><?php echo e(trans('file.Notes')); ?></a>
                        </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="remainingLeaveType-tab" data-toggle="tab" href="#remainingLeaveType"
                           role="tab" aria-controls="remainingLeaveType"
                           aria-selected="false"><?php echo e(trans('file.Files')); ?>

                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</section>

<?php echo $__env->yieldContent('lead_details'); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/crm/lead_section/layout.blade.php ENDPATH**/ ?>