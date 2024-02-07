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

        <form action="{{ route('store.processOrder') }}" method="post">
            @csrf
            <input type="hidden" id="totalInput" name="total" value="{{ $totalAmount }}">
            <input type="hidden" id="taxInput" name="tax" value="0">

            <div class="table-responsive">
                <table id="dataListTable" class="table ">
                    <thead>
                        <tr>
                            <th>{{trans('file.Item')}}</th>
                            <th>{{trans('file.Quantity')}}</th>
                            <th>{{trans('file.Rate')}}</th>
                            <th>{{trans('file.Total')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessionItems as $item)
                            <input type="hidden" class="itemId" name="item_id[]" value="{{ $item->id }}">
                            <input type="hidden" class="finalQuantity_{{$item->id}}" name="quantity[]" value="1">
                            <input type="hidden" name="rate[]" value="{{ $item->rate }}">
                            <input type="hidden" class="subtotal_{{$item->id}}" name="subtotal[]" value="{{ $item->rate }}">

                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <button data-id="{{$item->id}}" class="quantityDecrement" style="padding: 0;margin: 0;border: none; background: none; cursor: pointer;">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    &nbsp; <span class="quantity">1</span> &nbsp;
                                    <!-- / <small>{{ strtoupper($item->unit_type) }}</small> -->
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


            <div class="row">
                <div class="col-md-6">
                    <label class="text-bold ml-2"><strong>{{trans('file.Clients')}} <span class="text-danger"><b>*</b></span></label>
                    <select name="client_id"
                        required
                        class="ml-2 form-control selectpicker"
                        data-live-search="true" data-live-search-style="contains"
                        title="{{__('Selecting',['key'=>trans('file.Client')])}}...">
                        @foreach($clients as $item)
                            <option value="{{$item->id}}">{{$item->first_name.' '.$item->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="text-bold ml-2"><strong>{{trans('file.Tax')}} <span class="text-danger"><b>*</b></span></label>
                    <select name="tax_type_id"
                        id="taxType"
                        required
                        class="ml-2 selectpicker"
                        data-live-search="true" data-live-search-style="contains"
                        title="{{__('Selecting',['key'=>trans('file.Tax')])}}...">
                        @foreach($taxTypes as $tax_type)
                            <option value="{{$tax_type->rate}}">{{$tax_type->name}}({{$tax_type->rate}}%)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="ml-2 mt-4 mb-5 btn btn-success">@lang('file.Place Order')</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

    $(document).on('click', '.quantityDecrement', function(e) {
        e.preventDefault();
        calculateAndDisplay('decrement', this);
    });

    $(document).on('click', '.quantityIncrement', function(e) {
        e.preventDefault();
        $('#taxType').reset();
        
        calculateAndDisplay('increment', this);
    });


    $('#taxType').change(function () {
        let taxRate = parseInt($(this).val());
        let totalAmount = parseFloat($('#totalInput').val());
        let TaxOnAmount = (taxRate / 100 ) * totalAmount;
        let totalAmountIncludingTax = totalAmount + TaxOnAmount;

        if (TaxOnAmount > 0) {
            $('#totalAmount').empty().text(totalAmountIncludingTax.toFixed(2)+" (Including Tax)");
        }else{
            $('#totalAmount').empty().text(totalAmountIncludingTax.toFixed(2));
        }
        $('#taxInput').val(TaxOnAmount.toFixed(2));
        $('#totalInput').text(totalAmountIncludingTax.toFixed(2));

    });



    let calculateAndDisplay = (type, clickedElement) => {

        var rowId = $(clickedElement).data('id');
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
        $(clickedElement).closest('tbody').find('.finalQuantity_'+rowId).val(totalQuantity);

        $(clickedElement).closest('tr').find('.subtotal').text(subtotal.toFixed(2));
        $(clickedElement).closest('tbody').find('.subtotal_'+rowId).val(subtotal.toFixed(2));

        $('#totalAmount').text(newTotalAmount.toFixed(2));
        $('#totalInput').val(newTotalAmount.toFixed(2));

        // console.log('subtotal', subtotal);
        // console.log('prevTotalAmount :',prevTotalAmount);
        // console.log('newTotalAmount :',newTotalAmount);
    }


</script>
@endpush


