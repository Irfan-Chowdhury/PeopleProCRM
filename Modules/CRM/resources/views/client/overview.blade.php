@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-30px">
            <div><h1 class="thin-text">{{trans('file.Overview')}} </h1></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Total Client') }}</strong></div>
                        <div class="count-number employee-count">{{count($clients)}}</div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Total Subscription') }}</strong></div>
                        <div class="count-number employee-count">{{count($subscriptions)}}</div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Total Contract') }}</strong></div>
                        <div class="count-number employee-count">{{count($contracts)}}</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="wrapper count-title text-left">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Clients have paid invoices') }}</strong></div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped" style="width:{{ $invoices->paid_percentage }}%">{{ $invoices->paid_percentage }}%</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-left">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Clients have unpaid invoices') }}</strong></div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped" style="width:{{ $invoices->unpaid_percentage }}%">{{ $invoices->unpaid_percentage }}%</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-left">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Clients have sent invoices') }}</strong></div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped" style="width:{{ $invoices->sent_percentage }}%">{{ $invoices->sent_percentage }}%</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Total Pending Order') }}</strong></div>
                        <div class="count-number employee-count">{{$orderResult->totalPendingOrder}}</div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Total Completed Order') }}</strong></div>
                        <div class="count-number employee-count">{{$orderResult->totalCompletedOrder}}</div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wrapper count-title text-center">
                    <a href="">
                        <div class="name"><strong class="purple-text">{{ trans('file.Total Canceled Order') }}</strong></div>
                        <div class="count-number employee-count">{{$orderResult->totalCanceledOrder}}</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
