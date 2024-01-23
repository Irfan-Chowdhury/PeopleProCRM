@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Process Order')}}</h3></div>
    </div>
</div>

<div class="container">
    <div class="card">
        <h6 class="card-header">You are about to create the order. Please check details before submitting.</h6>

        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <thead>
                    <tr>
                        <th>{{trans('file.Item')}}</th>
                        <th>{{trans('file.Quantity')}}</th>
                        <th>{{trans('file.Rate')}}</th>
                        <th>{{trans('file.Sub-Total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessionItems as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>
                                <button data-id="{{$item->id}}" class="quantityDecrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                    <i class="fa fa-minus"></i>
                                </button>
                                &nbsp; <span class="quantity">1</span> &nbsp;
                                {{-- / <small>{{ strtoupper($item->unit_type) }}</small> --}}
                                <button data-id="{{$item->id}}" class="quantityIncrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                            <td class="rate">{{ $item->rate }}</td>
                            <td class="subtotal">{{ number_format($item->rate * 1, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2"></th>
                        <th> Total : </th>
                        <th id="totalAmount"> {{ number_format($totalAmount, 2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <label class="text-bold ml-2"><strong>{{trans('file.Clients')}}</label>
        <select name="client_id"
            class="ml-2 form-control selectpicker"
            data-live-search="true" data-live-search-style="contains"
            title="{{__('Selecting',['key'=>trans('file.Client')])}}...">
            @foreach($clients as $item)
                <option value="{{$item->id}}">{{$item->first_name.' '.$item->last_name}}</option>
            @endforeach
        </select>


        <button class="ml-2 mt-4 mb-5 btn btn-success">@lang('file.Place Order')</button>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

    $(document).on('click', '.quantityDecrement', function() {
        calculateAndDisplay('decrement', this);
    });

    $(document).on('click', '.quantityIncrement', function() {
        calculateAndDisplay('increment', this);
    });


    let calculateAndDisplay = (type, clickedElement) => {

        var quantity = parseInt($(clickedElement).siblings('span').text());

        if (type==='increment') {
            var totalQuantity = quantity + 1;
        }else {
            var totalQuantity = quantity - 1;

            if (totalQuantity < 1) {
                return;
            }
        }

        let rateElement = $(clickedElement).closest('tr').find('.rate');
        let rateValue = parseFloat(rateElement.text());

        let subtotal = totalQuantity * rateValue;

        let prevTotalAmount = parseFloat($('#totalAmount').text());
        let newTotalAmount;

        if (type =='increment') {
            newTotalAmount = prevTotalAmount + rateValue;
        } else {
            newTotalAmount = prevTotalAmount - rateValue;
        }

        $(clickedElement).siblings('span').text(totalQuantity);
        $(clickedElement).closest('tr').find('.subtotal').text(subtotal.toFixed(2));
        $('#totalAmount').text(newTotalAmount.toFixed(2));
        // console.log('subtotal', subtotal);
        // console.log('prevTotalAmount :',prevTotalAmount);
        // console.log('newTotalAmount :',newTotalAmount);
    }


</script>
@endpush


