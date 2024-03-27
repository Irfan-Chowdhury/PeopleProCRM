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


<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3><?php echo e(__('file.Client Details')); ?></h3></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('client.contracts.index') ? 'active' : ''); ?>" href="<?php echo e(url('client/contracts/show/' .$clientId)); ?>"><?php echo app('translator')->get('file.Contracts'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('client.proposals.index') ? 'active' : ''); ?>" href="<?php echo e(route('client.proposals.show',$clientId)); ?>"><?php echo e(trans('file.Proposals')); ?></a>
                    </li>
                    

                    
                </ul>

            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/client/include/header.blade.php ENDPATH**/ ?>