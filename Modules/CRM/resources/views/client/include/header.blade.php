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
            <div class="card-header"><h3>{{__('file.Client Details')}}</h3></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.contracts.index') ? 'active' : '' }}" href="{{ url('client/contracts/show/' .$clientId)  }}">@lang('file.Contracts')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.proposals.index') ? 'active' : '' }}" href="{{route('client.proposals.show',$clientId)}}">{{trans('file.Proposals')}}</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.task.index') ? 'active' : '' }}" id="set_salary-tab" href="{{ route('lead.task.index', $leadId) }}" role="tab"
                           aria-controls="Set_salary" aria-selected="false">{{__('Task')}}</a>
                    </li> --}}

                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.estimate.index') ? 'active' : '' }}"  href="{{ route('lead.estimate.index', $leadId) }}" role="tab"
                            >{{trans('file.Estimates')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.proposals.index') ? 'active' : '' }}"  href="{{ route('lead.proposals.index', $leadId) }}" role="tab"
                            >{{trans('file.Proposals')}}
                        </a>
                    </li>
                    <li class="nav-item">
                           <a class="nav-link {{ request()->routeIs('lead.contracts.index') ? 'active' : '' }}"  href="{{ route('lead.contracts.index', $leadId) }}" role="tab">{{trans('file.Contracts')}}</a>
                    </li>
                    <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('lead.notes.index') ? 'active' : '' }}"  href="{{ route('lead.notes.index', $leadId) }}" role="tab">{{trans('file.Notes')}}</a>
                        </li>
                    </li>
                    <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('lead.files.index') ? 'active' : '' }}"  href="{{ route('lead.files.index', $leadId) }}" role="tab">{{trans('file.Files')}}</a>
                        </li>
                    </li> --}}
                </ul>

            </div>
        </div>
    </div>
</section>
