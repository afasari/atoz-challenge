<?php

namespace App\Http\Controllers;

use App\Product;
use App\Orders;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        self::expired();    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expired()
    {
        $order_number = DB::table('orders')->where('created_at', '<', Carbon::now('Asia/Jakarta')->subMinutes(5) )->where('status', 1)->update(['status' => 0]);
        return $order_number;
    }
    public function payment()
    {
        return view('page.users.payment', [
            'order_number' => ""
        ]);
    }

    public function pay($order_number = null)
    {
        return view('page.users.payment', [
            'order_number' => $order_number
        ]);
    }

    public function test()
    {
        // $mytime = Carbon\Carbon::createFromTime($hour, $minute, $second, $tz);;
        // return $hour;

        $mytime = date("H");
        $mytime = Carbon::now();
        
        return $mytime;
        
        // return back();
    }

    public function paid(Request $request)
    {
        $user = Auth::User();     
        $user_id = $user->id;
        $order_number = DB::table('orders')->where('id', $request->input('order_number'))->exists();
        $order_status = DB::table('orders')->where('id', $request->input('order_number'))->where('user_id', $user_id)->where('status', 1)->exists();
        $order_user = DB::table('orders')->where('user_id', $user_id)->exists();
        $user = DB::table('orders')->where('id', $request->input('order_number'))->first();
        var_dump($user);
        var_dump($order_number);
        if(!$order_number){
            return back()->withErrors('Order Number is Not Valid');
        }
        if(!$order_status){
            return 'Order is canceled/already paid';
        }
        if(!$order_user){
            return 'Order is not belong to you';
        }
        $dt = Carbon::now('Asia/Jakarta');        
        $order_update = Orders::find( $request->input('order_number') );
        if($order_update->type==1){
            if($dt->hour>=9&&$dt->hour<=17){
                $success = self::randomDaylight();   
                if($success){
                    $order_update->status = 2;
                    $order_update->paid_time = Carbon::now('Asia/Jakarta');                
                    $order_update->save();
                    $withe = "Prepaid success";                                
                }
                else{
                    $order_update->status = 3;
                    $order_update->paid_time = Carbon::now('Asia/Jakarta');                
                    $order_update->save();
                    $withe = "Prepaid failed due paid time success rate";                
                }
            }
            else{
                $success = self::randomOtherwise();   
                if($success){
                    $order_update->status = 2;
                    $order_update->paid_time = Carbon::now('Asia/Jakarta');                
                    $order_update->save();
                    $withe = "Prepaid success";                                
                }
                else{
                    $order_update->status = 3;
                    $order_update->paid_time = Carbon::now('Asia/Jakarta');                
                    $order_update->save();
                    $withe = "Prepaid failed due paid time success rate";                
                }
            }
        }
        elseif($order_update->type==2){
            $shipping_number = self::shippingNumber();
            $order_update->status = 2;
            $order_update->paid_time = Carbon::now('Asia/Jakarta');
            $order_update->save();
            $order_shipping = Product::where('order_number', $request->input('order_number') )->first();            
            $order_shipping->shipping = $shipping_number;
            $order_shipping->save();
            $withe = "Shipping number created";
        }
        
        // ngecek balance atau product, kasi action
        // return view('page.test', [
        //     'user' => $order_number
        // ]);
        return redirect('order')->withErrors($withe);
        
        // return back()->with('orders', $user);
    }


    public function cancel($order_number = null)
    {
        $order_update = Orders::find( $order_number );
        $order_update->status = 0;
        $order_update->save();
        return redirect('order')->withErrors("Order Cancelled");
    }

    public function order(Request $request)
    {
        $user = Auth::User();     
        $user_id = $user->id;
        if(count($request->order_number)<10&&count($request->order_number)>0){
            // return "1-9";
            $products = DB::table('orders')
            ->leftJoin('products', 'orders.id', '=', 'products.order_number')
            ->leftJoin('balances', 'orders.id', '=', 'balances.order_number')
            ->select('orders.*','orders.id as order_number', 'products.product', 'products.address', 'products.price', 'products.shipping', 'balances.mobile_phone', 'balances.balance')
            ->where('orders.id', 'like','%'. $request->order_number . '%')
            ->paginate(20);
        }
        elseif(count($request->order_number)==10){
            // return "10";            
            $products = DB::table('orders')
            ->leftJoin('products', 'orders.id', '=', 'products.order_number')
            ->leftJoin('balances', 'orders.id', '=', 'balances.order_number')
            ->select('orders.*','orders.id as order_number', 'products.product', 'products.address', 'products.price', 'products.shipping', 'balances.mobile_phone', 'balances.balance')
            ->where('orders.id', $request->order_number)
            ->paginate(20);
        }
        else{
            $products = DB::table('orders')
            ->leftJoin('products', 'orders.id', '=', 'products.order_number')
            ->leftJoin('balances', 'orders.id', '=', 'balances.order_number')
            ->select('orders.*','orders.id as order_number', 'products.product', 'products.address', 'products.price', 'products.shipping', 'balances.mobile_phone', 'balances.balance')
            ->paginate(20);
        }

        return view('page.users.order', [
            'products' => $products,
            'status' => ""
        ]);            
    }

    function orderNumber() {
        $number = mt_rand(1000000000, mt_getrandmax());
        if (self::orderNumberExists($number)) {
            return self::orderNumber();
        }
        return $number;
    }
    
    function orderNumberExists($number) {
        return $user = DB::table('orders')->where('id', $number)->first();
    }

    function shippingNumber($len = 8) {
        $word = array_merge(range('A', 'Z'));
        shuffle($word);
        $number = substr(implode($word), 0, $len);
        if (self::shippingNumberExists($number)) {
            return self::shippingNumber();
        }
        return $number;
    }
    
    function shippingNumberExists($number) {
        return $user = DB::table('products')->where('shipping', $number)->first();
    }


    function randomDaylight() {
        $number = mt_rand(1, 100);
        if($number<60)
        return true;
    }
    function randomOtherwise() {
        $number = mt_rand(1, 100);
        if($number<40)
        return true;
    }

    public function receipt(Request $request)
    {
        $user = Auth::User();     
        $user_id = $user->id;
        $order_number = self::orderNumber();

        if($request->input('receipt')==1){
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|numeric|regex:/(081)[0-9]{4,9}/',
                'value' => 'required',
            ]);
            
            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $result=DB::insert("insert into orders(user_id,id,status,type,created_at,updated_at) values(?,?,?,?,?,?)",[$user_id,$order_number,1,$request->input('receipt'),Carbon::now('Asia/Jakarta'),Carbon::now('Asia/Jakarta')]);
            $result=DB::insert("insert into balances(mobile_phone,balance,order_number,created_at,updated_at) values(?,?,?,?,?)",[$request->input('mobile'),$request->input('value'),$order_number,Carbon::now('Asia/Jakarta'),Carbon::now('Asia/Jakarta')]);
            $total = 1.05 * $request->input('value');
            
            return view('page.users.receipt', [
                'mobile' => $request->input('mobile'),
                'value' => $request->input('value'),
                'total' => $total,
                'feature' => $request->input('receipt'),
                'order_number' => $order_number
            ]);   
        }
        elseif($request->input('receipt')==2){
            $validator = Validator::make($request->all(), [
                'product' => 'required|min:10|max:150',
                'address' => 'required|min:10|max:150',
                'price' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $result=DB::insert("insert into orders(user_id,id,status,type,created_at,updated_at) values(?,?,?,?,?,?)",[$user_id,$order_number,1,$request->input('receipt'),Carbon::now('Asia/Jakarta'),Carbon::now('Asia/Jakarta')]);
            $result=DB::insert("insert into products(product,address,price,order_number,created_at,updated_at) values(?,?,?,?,?,?)",[$request->input('product'),$request->input('address'),$request->input('price'),$order_number,Carbon::now('Asia/Jakarta'),Carbon::now('Asia/Jakarta')]);

            $total = 10000 + $request->input('price');            

            return view('page.users.receipt', [
                'product' => $request->input('product'),
                'address' => $request->input('address'),
                'price' => $request->input('price'),
                'total' => $total,
                'feature' => $request->input('receipt'),
                'order_number' => $order_number
            ]);   
        }
        else{
            return view('error.404');
        }
        
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
