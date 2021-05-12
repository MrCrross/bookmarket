<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Limit;
use App\Models\Product;
use App\Models\Publisher;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $products =Product::with('genres.genre','limit','publisher','author')->latest()->get();
        $authors=Author::with('products')->get();
        $genres = Genre::with('products.product.author')->get();
        $limits = Limit::where('name','16+')->with('products.author')->get();
        return view('shop.index',['products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $products = Product::where('id',$id)->with('genres.genre','limit','images','publisher','author')->get();
        $authors=Author::join('products','authors.id','=','products.author_id')->where('products.id',$id)->select('authors.*')->with('products')->get();
        $genres = Genre::join('product_genres','genres.id','=','product_genres.genre_id')->where('product_genres.id',$id)->select('genres.*')->with('products.product.author')->get();
        $limits = Limit::join('products','limits.id','=','products.limit_id')->where('products.id',$id)->select('limits.*')->with('products.author')->get();
        return view('shop.show',['products'=>$products,'authors'=>$authors,'genres'=>$genres,'limits'=>$limits]);
    }
}
