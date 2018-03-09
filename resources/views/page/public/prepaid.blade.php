@extends('layouts.default')

@section('content')

<div class="container">
    <div class="row flex-center">
        <div class="col-md-12 col-md-offset-4">
            <div class="panel panel-default">
                <hr>
                <h1>Prepaid Balance</h1>
                <h5>We Provide Everything </h5>
                <hr>

                <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{URL::to('receipt')}}">
                    @csrf         
                    <div class="form-group" style="display:none;">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Product Type</div>
                                <input class="form-control col-md-8" type="text" name="receipt" value="1" required ></input>
                            </div>
                        </div>
                    </div>                 
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Mobile Phone Number</div>
                                <input class="form-control col-md-8" type="text" placeholder="7-12 Digit Start with 081" name="mobile" value="{{old('mobile')}}" required ></input>

                                @if ($errors->has('mobile'))
                                    <p class="text-center">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-left">Value</div>

                                <select id="value" required name="value" class="col-md-8 form-control">                      
                                <option value="">--Select Value--</option>
                                <option value="10000">10000</option>
                                <option value="50000">50000</option>
                                <option value="100000">100000</option>
                                </select>
                                @if ($errors->has('value'))
                                    <p class="text-center">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </p>
                                @endif
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
