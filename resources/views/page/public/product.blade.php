@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row flex-center">
        <div class="col-md-12 col-md-offset-4">
            <div class="panel panel-default">
                <hr>
                <h1>Product Commerce</h1>
                <h5>We Provide Everything </h5>
                <hr>

                <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{URL::to('receipt')}}">
                @csrf
                
                <div class="form-group"  style="display:none;">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Product Type</div>
                                <input class="form-control col-md-8" type="text" name="receipt" value="2" required ></input>
                            </div>
                        </div>
                    </div>              
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Product</div>
                                <textarea class="form-control col-md-8" type="text" placeholder="Product"   maxlength="150"  name="product" required></textarea>
                                
                                @if ($errors->has('product'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Shipping Address</div>
                                <textarea class="form-control col-md-8" type="text" placeholder="Shippping Address"   maxlength="150"  name="address" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Price</div>
                                <input class="form-control col-md-8" type="number" placeholder="Price" name="price" required></input>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="container"><div class="row">
                        <div class="col-md-6"></div><div class="col-md-6"><button type="submit" class="btn btn-primary form-control">Submit</button></div>
                    </div></div></div>
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
