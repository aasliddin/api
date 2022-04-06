<?php

namespace App\Http\Controllers;
use App\Models\Status;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function createStatus(Request $request)
    {
        if(Auth::user()->role==2){
            if(empty($request->text)){
                return response()->json([
                    'msg'=> "Text empty"
                ], 422); 
            }
            if(empty($request->messages_id)){
                return response()->json([
                    'msg'=> " id empty"
                ], 422);        
            }
            if(Status::create(
                [
                    'text'=>$request->text,
                    'user_id'=>Auth::user()->id,
                    'messages_id'=>$request->messages_id
                ]
            ))
           {
                Messages::find($request->messages_id)->update(
                    [
                        'status'=>"1",
                    ]
                    );
                    return response()->json([
                        'succes'
                    ], 200);  
           }
            
        }
        return response()->json([
            'eror'
        ], 400);   
    }
    public function updateStatus(Request $request)
    {
        if(Auth::user()->role==2)
        {
            if(empty($request->text)){
                return response()->json([
                    'msg'=> "Text empty"
                ], 422);        
            }
            if(empty($request->status_id)){
                return response()->json([
                    'msg'=> " id empty"
                ], 422);        
            }
            if(Status::find($request->status_id)->update(
                [
                    'text'=>$request->text,
                ]
            ))
            {
                        return response()->json([
                            'succes'
                        ], 200);  
            }
        }
        return response()->json([
        'eror'
    ], 400);  
    }
}
