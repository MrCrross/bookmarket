<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Product;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $user =Auth::user();
        DB::beginTransaction();
        try{
            foreach ($request->last_name as $key=> $last_name) {
                $data=[
                    'last_name'=>$last_name,
                    'first_name'=>$request->first_name[$key],
                ];

                if(isset($request->father_name[$key])){
                    $data['father_name']=$request->father_name[$key];
                    $data['initials']=mb_strtoupper(mb_substr($request->first_name[$key],0,1)).".".mb_strtoupper(mb_substr($request->father_name[$key],0,1)).".";
                }else{
                    $data['initials']=mb_strtoupper(mb_substr($request->first_name[$key],0,1)).".";
                }
                $author=Author::create($data);
                UserLog::create([
                    'user_id'=>$user->getAuthIdentifier(),
                    'actions'=>'Create author: '.$author->last_name." ".$author->initials
                ]);
                DB::commit();
            }
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>$e
            ]);
        }
        return response()->json([
            'authors'=>Author::all(),
            'result'=>'Авторы пополнены успешно!'
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
            $data=[
                'last_name'=>$request->last_name,
                'first_name'=>$request->first_name,
            ];
            if(isset($request->father_name)){
                $data['father_name']=$request->father_name;
                $data['initials']=mb_strtoupper(mb_substr($request->first_name,0,1)).".".mb_strtoupper(mb_substr($request->father_name,0,1)).".";
            }else{
                $data['initials']=mb_strtoupper(mb_substr($request->first_name,0,1)).".";
            }
            Author::where('id',$request->id)->update($data);
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Update author: '.$data['last_name']." ".$data['initials']
            ]);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>$e
            ]);
        }
        return response()->json([
            'authors'=>Author::all(),
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Автор изменен успешно!'
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
            $author=Author::where('id',$request->id)->get()[0];
            UserLog::create([
                'user_id'=>$user->getAuthIdentifier(),
                'actions'=>'Delete author: '.$author->last_name.$author->initials
            ]);
            Author::where('id',$request->id)->delete();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'result'=>$e
            ]);
        }
        return response()->json([
            'authors'=>Author::all(),
            'products'=>Product::with('genres.genre','images','limit','publisher','author')->get(),
            'result'=>'Автор удалён успешно!'
        ]);
    }
}
