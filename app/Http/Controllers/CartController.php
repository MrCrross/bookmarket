<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\UserLog;
use App\Models\ProductLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $products = Product::where('id',$id)->with('genres.genre','limit','images','publisher','author')->get();
        return view('shop.show',['products'=>$products]);
    }
    public function create(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            Cart::create([
                'product_id'=>$request->id,
                'user_id'=>$user->getAuthIdentifier(),
            ]);
            ProductLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'product_id'=>$request->id
            ]);
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Added product: '.Product::where('id',$request->id)->select('name')->get()[0]->name.' to cart'
            ]);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json('Error: '.$e);
        }
        return response()->json('OK');
    }
}
