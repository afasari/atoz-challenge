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
                
                <div class="row">
                <div class="col-md-4"><a href="/prepaid-balance" class="btn btn-info form-control">Prepaid Balance</a></div>
                <div class="col-md-4"><a href="/product" class="btn btn-info form-control">Product Commerce</a></div>
                @guest 
                <div class="col-md-2"><a href="/login" class="btn btn-info form-control">Login</a></div><div class="col-md-2"><a href="/register" class="btn btn-info form-control">Register</a></div>                
                @else              
                <div class="col-md-4"><a href="/order" class="btn btn-info form-control">List Order</a></div>                
                @endguest
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
