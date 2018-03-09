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
                <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/paid')}}">
                @csrf
                @if($errors->any())
                    <div class="alert alert-warning">
                    <strong>Warning!</strong> 
                    {{$errors->first()}}
                    </div>
                @endif
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Order Number</div>
                                <input class="form-control col-md-8" type="text" placeholder="Input your order number" value="{{$order_number}}" name="order_number"></input>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="container"><div class="row">
                        <div class="col-md-12"><button type="submit" class="btn btn-primary form-control">Pay</button></div>
                    </div></div></div>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
