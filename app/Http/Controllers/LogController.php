<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * LogController constructor.
     */
    function __construct(){
        $this->middleware('permission:logs-delete', ['only' => ['destroy']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request){
        UserLog::where('id',$request->id)->delete();
        return redirect()->route('lk');
    }
}
