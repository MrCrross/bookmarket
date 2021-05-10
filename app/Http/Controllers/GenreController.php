<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Product;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    /**
     * GenreController constructor.
     */
    function __construct(){
        $this->middleware('permission:genre-create|genre-edit|genre-delete', ['only' => ['index','search']]);
        $this->middleware('permission:genre-create', ['only' => ['create']]);
        $this->middleware('permission:genre-edit', ['only' => ['update']]);
        $this->middleware('permission:genre-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $genre = Genre::all();
        return view('genre.index',['genre'=>$genre]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            foreach ($request->name as $name) {
                $genre=Genre::create([
                    'name'=>$name
                ]);
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Create genre: '.$genre->name
                ]);
                DB::commit();
            }
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
           'genres'=>Genre::all(),
           'result'=>'Жанры пополнены успешно.'
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
            Genre::where('id',$request->id)->update([
                'name'=>$request->name
            ]);
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Update genre: '.$request->name
            ]);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'genres'=>Genre::all(),
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Жанр изменен успешно.'
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
            $genre=Genre::where('id',$request->id)->get()[0];
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Delete genre: '.$genre->name
            ]);
            Genre::where('id',$request->id)->delete();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'genres'=>Genre::all(),
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Жанр удалён успешно.'
        ]);
    }
}
