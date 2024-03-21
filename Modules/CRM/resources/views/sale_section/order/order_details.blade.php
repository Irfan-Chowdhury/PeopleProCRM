@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Order Details')}}</h3></div>
    </div>
</div>

<div class="container card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <thead>
                    <tr>
                        <th>{{trans('file.Item')}}</th>
                        <th>{{trans('file.Rate')}}</th>
                        <th>{{trans('file.Quantity')}}</th>
                        <th>{{trans('file.Total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $value)
                        <tr>
                            <td>{{ $value->item->title }}</td>
                            <td>{{ $value->rate }}</td>
                            <td>{{ $value->quantity }}</td>
                            <td>{{ $value->quantity * $value->rate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <tbody>

                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Subtotal : {{ $order->orderDetails->sum('subtotal') }}</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Tax : {{ $order->tax}}</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Total : {{ $order->total }}</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
