@extends('layout.main')
@section('content')

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

@php
    $url = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $url);
    $leadId = (int) $urlParts[3];
@endphp

<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3>{{__('file.Lead Details')}}</h3></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.contact.index') ? 'active' : '' }}" href="{{ route('lead.contact.index', $leadId) }}">{{trans('file.Contact')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.info.show') ? 'active' : '' }}" href="{{ route('lead.info.show', $leadId) }}">{{trans('file.Lead Info')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lead.task.index') ? 'active' : '' }}" id="set_salary-tab" href="{{ route('lead.task.index', $leadId) }}" role="tab"
                           aria-controls="Set_salary" aria-selected="false">{{__('Task')}}</a>
                    </li>

                    <li class="nav-item">
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
                        <a class="nav-link" id="employee_project_task-tab" data-toggle="tab"
                           href="#Employee_project_task" role="tab" aria-controls="Employee_project_task"
                           aria-selected="false"> {{trans('file.Estimate Request')}}</a>
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
                        <a class="nav-link" id="remainingLeaveType-tab" data-toggle="tab" href="#remainingLeaveType"
                           role="tab" aria-controls="remainingLeaveType"
                           aria-selected="false">{{trans('file.Files')}}
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</section>

@yield('lead_details')


@endsection
