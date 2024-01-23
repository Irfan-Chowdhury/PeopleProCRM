@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="d-flex justify-content-between">
            <div class="card-header"><h3>{{__('file.Store')}}</h3></div>
            <div class="card-header">
                <a href="{{ route('store.processOrder') }}" class="btn btn-info">
                Checkout
                @if(config('variable.currency_format') =='suffix')
                    ( {{ number_format($totalAmount, 2) }} {{config('variable.currency')}} )
                @else
                    ( {{ config('variable.currency')}} {{ number_format($totalAmount, 2) }} )
                @endif
                </a>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        @foreach ($items as $item)
            <div class="col-md-4">
                <form action="{{ route('store.addToCart', $item->id) }}" method="post">
                    @csrf
                    <div class="card" style="width: 18rem;">
                        @if ($item->image)
                            <img class="card-img-top" src="{{ asset('uploads/crm/items/'.$item->image) }}" alt="Card image cap" width="300px" height="200px" >
                        @else
                            <img class="card-img-top" src="{{ asset('logo/empty.jpg') }}" alt="Card image cap" width="300px" height="200px" >
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">
                                @if(config('variable.currency_format') =='suffix')
                                    <span class="text-danger" style="font-family: DejaVu Sans; sans-serif;">{{ $item->rate }}{{config('variable.currency')}}</span>
                                @else
                                    <span class="text-danger" style="font-family: DejaVu Sans; sans-serif;">{{config('variable.currency')}}{{ $item->rate }}</span>
                                @endif
                                / <small>{{ $item->unit_type }}</small></p>
                            <p class="card-text">{{ $item->description }}</p>

                            @if ($sessionItemsIds && in_array($item->id, $sessionItemsIds))
                                <button disabled class="btn btn-success text-center">Added</button>
                            @else
                                <button type="submit" class="btn btn-primary text-center">Add to Cart</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>


@endsection

