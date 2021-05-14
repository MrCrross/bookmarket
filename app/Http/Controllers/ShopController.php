<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Cart;
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
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
        }
        $carts=[];
        if($user){
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $products =Product::with('genres.genre','limit','publisher','author')->latest()->get();
        $authors=Author::with('products')->get();
        $genres = Genre::with('products.product.author')->get();
        $limits = Limit::where('name','16+')->with('products.author')->get();
        return view('shop.index',['recom'=>$recom,'carts'=>json_encode($carts),'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $products = Product::where('id',$id)->with('author')->get();
        $authors=Author::with('products')->whereHas('products',function ($query) use ($id) {$query->where('id',$id);})->get();
        $genres = Genre::with('products.product.author')->whereHas('products',function ($query) use ($id) {$query->where('product_id',$id);})->get();
        $limits = Limit::with('products.author')->whereHas('products',function ($query) use ($id) {$query->where('id',$id);})->get();
        return view('shop.show',['recom'=>$recom,'carts'=>json_encode($carts),'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function shop(){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $news = Product::with('author')->latest()->get();
        $products = Product::with('genres.genre','limit','images','publisher','author')->latest()->paginate($this->size);
        $authors=Author::all();
        $genres = Genre::all();
        $publishers = Publisher::all();
        $limits = Limit::all();
        return view('shop.shop',['recom'=>$recom,'carts'=>json_encode($carts),'news'=>$news,'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits,'publishers'=>$publishers]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function filter(Request $request){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $news = Product::with('author')->latest()->get();
        $products = new Product();
        $products =$products->with('genres.genre','limit','publisher','author');
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
        return view('shop.shop',['recom'=>$recom,'carts'=>json_encode($carts),'news'=>$news,'products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits,'publishers'=>$publishers]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function author($id){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $news = Product::with('author')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author')
            ->whereHas('author',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.author',['recom'=>$recom,'carts'=>json_encode($carts),'news'=>$news,'products'=>$products]);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function publisher($id){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $news = Product::with('author')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author')
            ->whereHas('publisher',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.publisher',['recom'=>$recom,'carts'=>json_encode($carts),'news'=>$news,'products'=>$products]);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function genre($id){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $news = Product::with('author')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author')
            ->whereHas('genres.genre',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.genre',['recom'=>$recom,'carts'=>json_encode($carts),'news'=>$news,'products'=>$products]);
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function limit($id){
        $user=Auth::user();
        $recom = [];
        $carts=[];
        if($user){
            $logs =ProductLog::where('user_id',$user->getAuthIdentifier())->select('product_id')->get()->toArray();
            $ids=[];
            foreach ($logs as $item){
                array_push($ids,$item['product_id']);
            }
            $recom=Author::with('products')->whereHas('products',function ($query) use ($ids) {$query->whereIn('id',$ids);})->get()->toArray();
            foreach(Cart::where('user_id',$user->getAuthIdentifier())->select('product_id','count')->get()->toArray() as $item){
                array_push($carts,[
                    "product_id"=>$item['product_id'],
                    "count"=>$item['count']
                ]);
            };
        }
        $news = Product::with('author')->latest()->get();
        $products = Product::with('genres.genre','limit','publisher','author')
            ->whereHas('limit',function ($query) use ($id) {
                $query->where('id',$id);
            })
            ->latest()->paginate($this->size);
        return view('shop.limit',['recom'=>$recom,'carts'=>json_encode($carts),'news'=>$news,'products'=>$products]);
    }
}
