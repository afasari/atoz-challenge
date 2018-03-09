@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row flex-center">
        <div class="col-md-12 col-md-offset-4">
            <div class="panel panel-default">
                <hr>
                <h1>AtoZ Challenge</h1>
                <h5>We Provide Everything </h5>
                <hr>

                <div class="panel-body">
                    Your Order Number<br>
                    {{ $order_number }}<br>
                    <hr>
                    Total<br>
                    {{ $total }}
                    <hr>
                    @if($feature==1)
                    
                    Your Mobile Phone Number {{ $mobile }} will be topped up for {{ $value }} after you pay<hr>
                    @elseif($feature==2)
                    {{ $product }} that cost {{ $price }} will be shipped to {{$address}} after you pay<hr>
                    @endif
                    <div class="container"><div class="row">
                        <div class="col-md-2"></div><div class="col-md-8"><a href="/payment/{{ $order_number }}" class="btn btn-info form-control">Pay Here</a></div>                        
                        <div class="col-md-2"></div>
                    </div></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
