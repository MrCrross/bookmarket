<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Limit;
use App\Models\Product;
use App\Models\ProductLog;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{

    private $size = 15;
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $user=Auth::user();
        $recom = [];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products.carts')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
        }
        $products =Product::with('genres.genre','limit','publisher','author','carts')->latest()->get();
        $authors=Author::with('products.carts')->get();
        $genres = Genre::with('products.product.author','products.product.carts')->get();
        $limits = Limit::where('name','16+')->with('products.author','products.carts')->get();
        return view('shop.index',['recom'=>$recom,'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $user=Auth::user();
        if($user){
            $log =ProductLog::where('user_id',$user->getAuthIdentifier())->where('product_id',$id)->get();
            if(count($log)===0){
                ProductLog::create([
                    'product_id'=> $id,
                    'user_id'=>$user->getAuthIdentifier()
                ]);
            }
        }
        $products = Product::where('id',$id)->with('author','carts')->get();
        $authors=Author::with('products.carts')->whereHas('products',function ($query) use ($id) {$query->where('id',$id);})->get();
        $genres = Genre::with('products.product.author','products.product.carts')->whereHas('products',function ($query) use ($id) {$query->where('product_id',$id);})->get();
        $limits = Limit::with('products.author','products.carts')->whereHas('products',function ($query) use ($id) {$query->where('id',$id);})->get();
        return view('shop.show',['products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function shop(){
        $news = Product::with('author','carts')->latest()->get();
        $products = Product::with('genres.genre','limit','images','publisher','author','carts')->latest()->paginate($this->size);
        $authors=Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        $limits = Limit::all();
        return view('shop.shop',['news'=>$news,'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits,'publishers'=>$publishers]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function filter(Request $request){
        $news = Product::with('author','carts')->latest()->get();
        $products = new Product();
        $products =$products->with('genres.genre','limit','publisher','author','carts');
        if(isset($request->author)){
            $products =$products->whereHas('author',function ($query) use ($request) {
                $query->whereIn('id',$request->author);
            });
        }
        if(isset($request->publisher)){
            $products =$products->whereHas('publisher',function ($query) use ($request) {
                $query->whereIn('id',$request->publisher);
            });
        }
        if(isset($request->genre)){
            $products =$products->whereHas('genres.genre',function ($query) use ($request) {
                $query->whereIn('id',$request->genre);
            });
        }
        if(isset($request->limit)){
            $products =$products->whereHas('limit',function ($query) use ($request) {
               $query->whereIn('id',$request->limit);
            });
        }
        $products =$products->latest()->paginate($this->size);
        $authors=Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        $limits = Limit::all();
        return view('shop.shop',['news'=>$news,'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits,'publishers'=>$publishers]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function author($id){
        $news = Product::with('author','carts')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author','carts')
            ->whereHas('author',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.author',['news'=>$news,'products'=>$products]);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function publisher($id){
        $news = Product::with('author','carts')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author','carts')
            ->whereHas('publisher',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.publisher',['news'=>$news,'products'=>$products]);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function genre($id){
        $news = Product::with('author','carts')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author','carts')
            ->whereHas('genres.genre',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.genre',['news'=>$news,'products'=>$products]);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function limit($id){
        $news = Product::with('author','carts')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author','carts')
            ->whereHas('limit',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.limit',['news'=>$news,'products'=>$products]);
    }
}
