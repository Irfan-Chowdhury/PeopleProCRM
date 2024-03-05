@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-30px">
            <div><h1 class="thin-text">{{trans('file.Welcome')}} </h1></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="wrapper count-title text-center">
                <a href="">
                    <div class="name"><strong class="purple-text">{{ trans('file.Total Client') }}</strong></div>
                    <div class="count-number employee-count">{{count($clients)}}</div>
                </a>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="wrapper count-title text-center">
                <a href="">
                    <div class="name"><strong class="purple-text">{{ trans('file.Total Subscription') }}</strong></div>
                    <div class="count-number employee-count">{{count($subscriptions)}}</div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
