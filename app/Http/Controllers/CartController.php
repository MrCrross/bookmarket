<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function index(Request $request)
    {
        $user=Auth::user();
        $carts=[];
        $data=[];
        if($user){
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    'product_id'=>$item['product_id'],
                    'count'=>$item['count']
                ]);
            };
            if(isset($request->products)){
                foreach (json_decode($request->products) as $cart){
                    array_push($data,$cart->product_id);
                }
            }else{
                foreach ($carts as $cart){
                    array_push($data,$cart['product_id']);
                }
            }
        }else{
            $carts = json_decode($request->products);
            foreach (json_decode($request->products) as $cart){
                array_push($data,$cart->product_id);
            }
        }
        $products =Product::with('author','genres.genre','publisher')->whereIn('id',$data)->get();
        return view('shop.cart',['carts'=>json_encode($carts),'products'=>$products]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $user =Auth::user();
        Cart::create([
            'product_id' => $request->productId,
            'user_id' => $user->getAuthIdentifier(),
            'count' => $request->count
        ]);
        return response()->json('OK');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user =Auth::user();
        Cart::where('product_id',$request->productId)
            ->where('user_id',$user->getAuthIdentifier())
            ->update([
                'count' => $request->count
            ]);
        return response()->json('OK');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request){
        Cart::where('user_id',$request->user_id)->delete();
        return response()->json('OK');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request){
        Cart::where('user_id',Auth::user()->getAuthIdentifier())->where('product_id',$request->productId)->delete();
        return response()->json('OK');
    }
}
