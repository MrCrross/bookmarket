<?php

namespace App\Http\Controllers;

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
}
