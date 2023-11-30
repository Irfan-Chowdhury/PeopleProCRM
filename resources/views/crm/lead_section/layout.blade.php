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
                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#General" role="tab"
                           aria-controls="General" aria-selected="true">{{trans('file.Contact')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#Profile" role="tab"
                           aria-controls="Profile" aria-selected="false">{{trans('file.Lead Info')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="set_salary-tab" data-toggle="tab" href="#Set_salary" role="tab"
                           aria-controls="Set_salary" aria-selected="false">{{__('Task')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="leave-tab" data-toggle="tab" href="#Leave" role="tab"
                           aria-controls="Leave" aria-selected="false">{{trans('file.Estimates')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="employee_core_hr-tab" data-toggle="tab" href="#Employee_Core_hr"
                           role="tab" aria-controls="Employee_Core_hr" aria-selected="false">{{__('Proposals')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="employee_project_task-tab" data-toggle="tab"
                           href="#Employee_project_task" role="tab" aria-controls="Employee_project_task"
                           aria-selected="false"> {{trans('file.Estimate Request')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="employee_payslip-tab" data-toggle="tab" href="#Employee_Payslip"
                           role="tab" aria-controls="Employee_Payslip"
                           aria-selected="false">{{trans('file.Contract')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="remainingLeaveType-tab" data-toggle="tab" href="#remainingLeaveType"
                           role="tab" aria-controls="remainingLeaveType"
                           aria-selected="false">{{trans('file.Notes')}}
                        </a>
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
