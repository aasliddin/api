<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bolim;
class BolimController extends Controller
{
    public function getBolim(Request $request,$id)
    {
        if(empty($id)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        return response()->json(
            Bolim::where('bolim_id',$id)->get()
        , 200);  
    }
    public function createBolim(Request $request)
    {
        if(empty($request->bolim_id) and empty($request->name)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        return Bolim::create([
            'name'=>$request->name,
            'bolim_id'=>$request->bolim_id,
        ]);

    }
}
