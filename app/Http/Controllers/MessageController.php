<?php

namespace App\Http\Controllers;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessage()
    {
        if(Auth::user()->role==1)
            {
                $mes=Messages::where('user_id',Auth::user()->id)->with('reyting')->with('manager')->get();
                return response()->json(
                    $mes
                , 200);
            }
        $mes=Messages::with('user')->with('reyting')->with('manager.user')->get();
        return response()->json(
            $mes
        , 200);

    }

    public function createMessage(Request $request)
    {
        if(empty($request->text)){
            return response()->json([
                'msg'=> "Text empty"
            ], 422);        
        }
        if(strlen($request->text)<3){
            return response()->json([
                'msg'=> "Text 3tadan kam belgi"
            ], 422);        
        }
        return Messages::create(
            [
                'text'=>$request->text,
                'user_id'=>Auth::user()->id
            ]
        );
    }
    public function updateMessage(Request $request)
    {
        if(empty($request->text)){
            return response()->json([
                'msg'=> "Text empty"
            ], 422);        
        }
        if(empty($request->id)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        if(strlen($request->text)<3){
            return response()->json([
                'msg'=> "Text 3tadan kam belgi"
            ], 422);        
        }
        if(Messages::find($request->id)->update(
            [
                'text'=>$request->text,
                'user_id'=>Auth::user()->id
            ]
        ))
        return Messages::find($request->id);
        return  response()->json([
            'msg'=> "xato"
        ], 422);  
    }
}
