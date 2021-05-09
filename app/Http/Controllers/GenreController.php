<?php

namespace App\Http\Controllers;

use App\Models\Genre;
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
//        $this->middleware('permission:author-create|product-edit|product-delete', ['only' => ['index']]);
        $this->middleware('permission:genre-create', ['only' => ['create']]);
        $this->middleware('permission:genre-edit', ['only' => ['update']]);
        $this->middleware('permission:genre-delete', ['only' => ['destroy']]);
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
}
