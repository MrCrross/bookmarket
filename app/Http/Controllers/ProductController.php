<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Limit;
use App\Models\Product;
use App\Models\Publisher;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     */
    function __construct(){
        $this->middleware('permission:product-create|product-edit|product-delete', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create']]);
        $this->middleware('permission:product-edit', ['only' => ['update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $products =Product::with('genres.genre','images','limit','publisher','author')->get();
        $authors=Author::all();
        $publishers=Publisher::all();
        $genres = Genre::all();
        $limits = Limit::all();
        return view('products.index',['products'=>$products,'authors'=>$authors,'publishers'=>$publishers,'genres'=>$genres,'limits'=>$limits]);
    }

    public function create(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            foreach ($request->products as $product) {
                $url = Storage::disk('public')->put('images/product/', $request->main_img);
                $url = 'storage/' . $url;
                $createProduct=Product::create([
                    'ISBN'=>$product->ISBN,
                    'name'=>$product->name,
                    'pages'=>$product->pages,
                    'price'=>$product->price,
                    'image'=>$url,
                    'year_release'=>$product->year,
                    'limit_id'=>$product->limit,
                    'publisher_id'=>$product->publisher,
                    'author_id'=>$product->author
                ]);
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Create product: '.$createProduct->name
                ]);
                foreach ($product->images as $image){
                    $url = Storage::disk('public')->put('images/products', $request->main_img);
                }
                DB::commit();
            }
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Продукты пополнены успешно.'
        ]);
    }
}
