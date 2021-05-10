<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Publisher;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    /**
     * PublisherController constructor.
     */
    function __construct(){
//        $this->middleware('permission:author-create|product-edit|product-delete', ['only' => ['index']]);
        $this->middleware('permission:publisher-create', ['only' => ['create']]);
        $this->middleware('permission:publisher-edit', ['only' => ['update']]);
        $this->middleware('permission:publisher-delete', ['only' => ['destroy']]);
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
                $publisher=Publisher::create([
                    'name'=>$name
                ]);
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Create publisher: '.$publisher->name
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
            'publishers'=>Publisher::all(),
            'result'=>'Издательства пополнены успешно.'
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
            Publisher::where('id',$request->id)->update([
                'name'=>$request->name
            ]);
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Update publisher: '.$request->name
            ]);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'publishers'=>Publisher::all(),
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Издательство изменено успешно.'
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
            $publisher=Publisher::where('id',$request->id)->get()[0];
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Delete publisher: '.$publisher->name
            ]);
            Publisher::where('id',$request->id)->delete();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>'Error: '.$e
            ]);
        }
        return response()->json([
            'genres'=>Publisher::all(),
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Издательство удалёно успешно.'
        ]);
    }
}
