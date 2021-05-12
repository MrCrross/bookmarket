<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use App\Models\Limit;
use App\Models\Product;
use App\Models\ProductGenre;
use App\Models\ProductImage;
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
        $this->middleware('permission:product-create|product-edit|product-delete', ['only' => ['index','search']]);
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            foreach ($request->ISBN as $key=>$isbn) {
                $url = Storage::disk('public')->put('images/products', $request->main_img[$key]);
                $createProduct=Product::create([
                    'ISBN'=>$isbn,
                    'name'=>$request->name[$key],
                    'pages'=>$request->pages[$key],
                    'price'=>$request->price[$key],
                    'image'=>$url,
                    'year_release'=>$request->year_release[$key],
                    'description'=>$request->description[$key],
                    'limit_id'=>$request->limit[$key],
                    'publisher_id'=>$request->publisher[$key],
                    'author_id'=>$request->author[$key]
                ]);
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Create product: '.$createProduct->name
                ]);
                foreach ($request->genre[$key] as $genre){
                    $createGenre= ProductGenre::create([
                        'product_id'=>$createProduct->id,
                        'genre_id'=>$genre
                    ]);
                    $nameGenre =$createGenre->with('genre')->get();
                    UserLog::create([
                        'user_id'=>$user->getAuthIdentifier(),
                        'actions'=>'Create genre: '.$nameGenre[0]->genre->name.', for product '. $createProduct->name
                    ]);
                }
                if(isset($request->images[$key])){
                    foreach ($request->images[$key] as $image){
                        $url = Storage::disk('public')->put('images/products', $image);
                        $createImage= ProductImage::create([
                            'product_id'=>$createProduct->id,
                            'image'=>$url
                        ]);
                        UserLog::create([
                            'user_id'=>$user->getAuthIdentifier(),
                            'actions'=>'Create secondary image: '.$createImage->image.', for product '. $createProduct->name
                        ]);
                    }
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
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            $data=[];
            $nameProduct =Product::where('id',$request->id)->get()[0]->name;
            if(isset($request->ISBN)){
                $data['ISBN']=$request->ISBN;
            }
            if(isset($request->main_img)){
                Storage::disk('public')->delete($request->old_main_img);
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Delete main image: '.$request->old_main_img." product ".$nameProduct
                ]);
                $url = Storage::disk('public')->put('images/products', $request->main_img);
                $data['image']=$url;
            }
            if(isset($request->name)){
                $data['name']=$request->name;
            }
            if(isset($request->price)){
                $data['price']=$request->price;
            }
            if(isset($request->pages)){
                $data['pages']=$request->pages;
            }
            if(isset($request->year_release)){
                $data['year_release']=$request->year_release;
            }
            if(isset($request->description)){
                $data['description']=$request->description;
            }
            if(isset($request->limit)){
                $data['limit_id']=$request->limit;
            }
            if(isset($request->publisher)){
                $data['publisher_id']=$request->publisher;
            }
            if(isset($request->author)){
                $data['author_id']=$request->author;
            }
            Product::where('id',$request->id)->update($data);
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Update product: '.$nameProduct
            ]);
            foreach ($request->genre as $key=>$genre){
                if(isset($genre)){
                    if(isset($request->old_genre[$key])){
                        ProductGenre::where('product_id',$request->id)
                            ->where('genre_id',$request->old_genre[$key])->update([
                            'genre_id'=>$genre
                        ]);
                        UserLog::create([
                            'user_id'=>$user->getAuthIdentifier(),
                            'actions'=>'Update genre: '.
                                Genre::where('id',$request->old_genre[$key])->get()[0]->name.
                                ' on '.Genre::where('id',$genre)->get()[0]->name.', for product '. $nameProduct
                        ]);
                    }else{
                        $createGenre= ProductGenre::create([
                            'product_id'=>$request->id,
                            'genre_id'=>$genre
                        ]);
                        UserLog::create([
                            'user_id'=>$user->getAuthIdentifier(),
                            'actions'=>'Create genre: '.$createGenre->with('genre')->get()[0]->genre->name.', for product '. $nameProduct
                        ]);
                    }
                }
            }
            if(isset($request->images)){
                if(isset($request->old_images)){
                    foreach ($request->old_images as $image){
                        Storage::disk('public')->delete($image);
                    }
                }
                ProductImage::where('product_id',$request->id)->delete();
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Delete secondary images: '.$nameProduct
                ]);
                foreach ($request->images as $image){
                    $url = Storage::disk('public')->put('images/products', $image);
                    $createImage= ProductImage::create([
                        'product_id'=>$request->id,
                        'image'=>$url
                    ]);
                    UserLog::create([
                        'user_id'=>$user->getAuthIdentifier(),
                        'actions'=>'Create secondary image: '.$createImage->image.', for product '. $nameProduct
                    ]);
                }
            }
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Продукт изменен успешно.'
        ]);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            $product = Product::where('id',$request->id)->with('images')->get()[0];
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Delete product: '.$product->name
            ]);
            Product::where('id',$request->id)->delete();
            Storage::disk('public')->delete($product->image);
            foreach ($product->images as $image){
                Storage::disk('public')->delete($image->image);
            }
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Продукт удалён успешно.'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){
        $genres = Genre::join('product_genres','product_genres.genre_id','=','genres.id')
            ->where('name','like','%'.$request->search.'%')
            ->select('product_id')
            ->get()->toArray();
        $arr=[];
        foreach ($genres as $genre){
            array_push($arr,$genre['product_id']);
        }
        $products =Product::join('limits','limits.id','=','products.limit_id')
            ->join('publishers','publishers.id','=','products.publisher_id')
            ->join('authors','authors.id','=','products.author_id')
            ->where('limits.name','like','%'.$request->search.'%')
            ->orWhere('publishers.name','like','%'.$request->search.'%')
            ->orWhere('authors.last_name','like','%'.$request->search.'%')
            ->orWhere('authors.first_name','like','%'.$request->search.'%')
            ->orWhere('authors.father_name','like','%'.$request->search.'%')
            ->orWhere('products.name','like','%'.$request->search.'%')
            ->orWhere('products.ISBN','like','%'.$request->search.'%')
            ->orWhere('products.price','like','%'.$request->search.'%')
            ->orWhere('products.year_release','like','%'.$request->search.'%')
            ->orWhere('products.pages','like','%'.$request->search.'%')
            ->orWhereIn('products.id',$arr)
            ->select('products.*')
            ->with('genres.genre','images','limit','publisher','author')
            ->get();
        return response()->json([
            'products'=>$products,
        ]);
    }
}
