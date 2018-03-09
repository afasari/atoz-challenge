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
                
                @if($errors->any())
                    <div class="alert alert-info">
                    <strong>Success!</strong> 
                    {{$errors->first()}}
                    </div>
                @endif
                <!-- <div class="container"> -->
                        <form action="{{ url()->current() }}">
                        <div class="row">
                        
                            <div class="col-md-11">
                                <input type="text" name="order_number" class="form-control" placeholder="Search order number here">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                            
                        </form>
                <!-- </div> -->
                <table id="example" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="10%">Order No.</th>
                                                <th width="40%">Description</th>
                                                <th width="20%">Total</th>
                                                <th width="30%">Information</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                        
                                            <tr>
                                            <!-- <?php print_r($products); ?> -->
                                            <?php print_r($status); ?>
                                                <td>{{$product->order_number}}</td>
                                                @if($product->type==1)
                                                <td>{{$product->balance}} for {{$product->mobile_phone}}</td>
                                                <td>{{1.05*$product->balance}}</td>
                                                @elseif($product->type==2)
                                                <td>{{$product->product}} that cost {{$product->price}}</td>
                                                <td>{{10000+$product->price}}</td>                                            
                                                @endif
                                                <td class="text-center">
                                                    @if($product->status==1)   
                                                    <a class="btn btn-sm btn-success form-control" href="/payment/{{$product->order_number}}" title="Pay">Pay</a>                                                                                                                                                                                                             
                                                    <!-- <a class="btn btn-sm btn-warning" href="/cancel/{{$product->order_number}}" title="Cancel">Cancel</a>                                                                                                                                                                                                              -->
                                                    @elseif($product->status==2)                                                            
                                                        @if($product->type==1)
                                                        Success                                             
                                                        @else
                                                        Shipping Code : {{$product->shipping}}    
                                                        @endif       
                                                    @elseif($product->status==0)
                                                    <p style="color:red;">Canceled</p>     
                                                    @elseif($product->status==3)                                                            
                                                    Fail                                                            
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                    {!! $products->render() !!}
                                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
