<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHasProduct;
use App\Models\ProductLog;
use App\Models\Status;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $size = 15;
    /**
     * OrderController constructor.
     */
    function __construct(){
        $this->middleware('permission:order-edit', ['only' => ['index','update']]);
    }

    public function index()
    {
        $orders = Order::with('orders.product.author','user')->where('status_id','<',5)->latest()->paginate($this->size);
        $statuses = Status::all();
        return view('orders.index',['orders'=>$orders,'statuses'=>$statuses]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request){
        $id =Auth::user()->getAuthIdentifier();
        $order=Order::create([
            'user_id'=>$id,
            'status_id'=>1
        ]);
        foreach ($request->products as $key=> $product){
            OrderHasProduct::create([
                'order_id'=>$order->id,
                'product_id'=>$product,
                'count'=>$request->count[$key]
            ]);
            ProductLog::create([
                'product_id'=>$product,
                'user_id'=>$id
            ]);
            UserLog::create([
                'user_id'=>$id,
                'actions'=>'Create order: '.$order->id
            ]);
        }
        return redirect()->route('lk');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        Order::where('user_id',$request->user_id)->update([
            'status_id'=>$request->status
        ]);
        return redirect()->route('orders');
    }
}
