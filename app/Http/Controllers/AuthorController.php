<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * AuthorController constructor.
     */
    function __construct(){
//        $this->middleware('permission:author-create|product-edit|product-delete', ['only' => ['index']]);
        $this->middleware('permission:author-create', ['only' => ['create']]);
        $this->middleware('permission:author-edit', ['only' => ['update']]);
        $this->middleware('permission:author-delete', ['only' => ['destroy']]);
    }

    public function create(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            foreach ($request->last_name as $key=> $last_name) {
                if(isset($request->father_name[$key])){
                    $author=Author::create([
                        'last_name'=>$last_name,
                        'first_name'=>$request->first_name[$key],
                        'father_name'=>$request->father_name[$key],
                        'initials'=>strtoupper(substr($request->first_name[$key],0,1)).".".strtoupper(substr($request->father_name[$key],0,1))
                    ]);
                }else{
                    $author=Author::create([
                        'last_name'=>$last_name,
                        'first_name'=>$request->first_name[$key],
                        'initials'=>strtoupper(substr($request->first_name[$key],0,1))."."
                    ]);
                }
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Create author: '.$author->last_name." ".$author->initials
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
            'authors'=>Author::all(),
            'result'=>'Авторы пополнены успешно!'
        ]);
    }
}
