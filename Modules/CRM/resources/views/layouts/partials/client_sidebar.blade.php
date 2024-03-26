<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">

                <li><a href="{{url('/client/dashboard')}}"> <i
                                class="dripicons-meter"></i><span>{{trans('file.Dashboard')}}</span></a>
                </li>

                <li><a href="#Project_Management" aria-expanded="false" data-toggle="collapse"> <i
                                class="dripicons-checklist"></i><span>{{__('Project Management')}}</span></a>
                    <ul id="Project_Management" class="collapse list-unstyled ">

                        <li id="projects"><a
                                    href="{{route('clientProject')}}">{{trans(('file.Projects'))}}</a>
                        </li>

                        <li id="tasks"><a
                                    href="{{route('clientTask')}}">{{trans(('file.Tasks'))}}</a>
                        </li>
                    </ul>
                </li>


                <li><a href="#invoices" aria-expanded="false" data-toggle="collapse"> <i
                                class="dripicons-ticket"></i><span>{{trans('file.Invoice')}}</span></a>
                    <ul id="invoices" class="collapse list-unstyled ">
                        <li id="invoice"><a href="{{route('clientInvoice')}}">{{trans('file.Invoice')}}</a>
                        </li>

                        <li id="paid_invoice"><a href="{{route('clientInvoicePaid')}}">{{__('Invoice Payment')}}</a>
                        </li>

                    </ul>
                </li>

                @if ($isCrmModuleExist)
                    <li><a href="{{route('client.contracts.index')}}"> <i
                        class="fa fa-file-text"></i><span>{{trans('file.Contracts')}}</span></a>
                    </li>
                    <li><a href="{{route('client.proposals.index')}}"> <i
                        class="fa fa-slideshare"></i><span>{{trans('file.Proposals')}}</span></a>
                    </li>
                    <li><a href="{{route('client.subscription.index')}}"> <i
                        class="fa fa-sliders"></i><span>{{trans('file.Subscription')}}</span></a>
                    </li>
                    <li><a href="{{route('client.estimates.index')}}"> <i
                        class="fa fa-plane"></i><span>{{trans('file.Estimates')}}</span></a>
                    </li>
                    <li><a href="{{route('client.store.index')}}"> <i
                        class="fa fa-shopping-bag"></i><span>{{trans('file.Store')}}</span></a>
                    </li>
                    <li><a href="{{route('client.clientOrders')}}"> <i
                        class="fa fa-first-order"></i><span>{{trans('file.Orders')}}</span></a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
