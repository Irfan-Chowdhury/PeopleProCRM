@extends(isset($contract->client_id) && Auth::user()->role_users_id !==3 ? 'layout.main' : 'layout.client')
@section('content')


<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Contract Item Details')}}</h3></div>
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
                    @foreach ($contract->contractItems as $value)
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
                        <th>Tax : {{ $contract->tax->rate }}%</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Total : {{ $total }}</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <th></th>
                        <th>Total amount with tax: {{ $totalAmoutWithTax }}</th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
