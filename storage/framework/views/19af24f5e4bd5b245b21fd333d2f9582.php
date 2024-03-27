<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">

                <li><a href="<?php echo e(url('/client/dashboard')); ?>"> <i
                                class="dripicons-meter"></i><span><?php echo e(trans('file.Dashboard')); ?></span></a>
                </li>

                <li><a href="#Project_Management" aria-expanded="false" data-toggle="collapse"> <i
                                class="dripicons-checklist"></i><span><?php echo e(__('Project Management')); ?></span></a>
                    <ul id="Project_Management" class="collapse list-unstyled ">

                        <li id="projects"><a
                                    href="<?php echo e(route('clientProject')); ?>"><?php echo e(trans(('file.Projects'))); ?></a>
                        </li>

                        <li id="tasks"><a
                                    href="<?php echo e(route('clientTask')); ?>"><?php echo e(trans(('file.Tasks'))); ?></a>
                        </li>
                    </ul>
                </li>


                <li><a href="#invoices" aria-expanded="false" data-toggle="collapse"> <i
                                class="dripicons-ticket"></i><span><?php echo e(trans('file.Invoice')); ?></span></a>
                    <ul id="invoices" class="collapse list-unstyled ">
                        <li id="invoice"><a href="<?php echo e(route('clientInvoice')); ?>"><?php echo e(trans('file.Invoice')); ?></a>
                        </li>

                        <li id="paid_invoice"><a href="<?php echo e(route('clientInvoicePaid')); ?>"><?php echo e(__('Invoice Payment')); ?></a>
                        </li>

                    </ul>
                </li>

                <?php if($isCrmModuleExist): ?>
                    <li><a href="<?php echo e(route('client.contracts.index')); ?>"> <i
                        class="fa fa-file-text"></i><span><?php echo e(trans('file.Contracts')); ?></span></a>
                    </li>
                    <li><a href="<?php echo e(route('client.proposals.index')); ?>"> <i
                        class="fa fa-slideshare"></i><span><?php echo e(trans('file.Proposals')); ?></span></a>
                    </li>
                    <li><a href="<?php echo e(route('client.subscription.index')); ?>"> <i
                        class="fa fa-sliders"></i><span><?php echo e(trans('file.Subscription')); ?></span></a>
                    </li>
                    <li><a href="<?php echo e(route('client.estimates.index')); ?>"> <i
                        class="fa fa-plane"></i><span><?php echo e(trans('file.Estimates')); ?></span></a>
                    </li>
                    <li><a href="<?php echo e(route('client.store.index')); ?>"> <i
                        class="fa fa-shopping-bag"></i><span><?php echo e(trans('file.Store')); ?></span></a>
                    </li>
                    <li><a href="<?php echo e(route('client.clientOrders')); ?>"> <i
                        class="fa fa-first-order"></i><span><?php echo e(trans('file.Orders')); ?></span></a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/layouts/partials/client_sidebar.blade.php ENDPATH**/ ?>