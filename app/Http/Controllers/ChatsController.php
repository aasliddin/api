<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\Chats;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function getChat(Request $request,$id)
    {
        if(empty($id)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        return response()->json(
            Chats::where('message_id',$id)->with('user.bolim')->get()
        , 200);  
    }
    public function createChat(Request $request)
    {
        if(empty($request->message_id) and empty($request->text)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        return Chats::create([
            'text'=>$request->text,
            'message_id'=>$request->message_id,
            'user_id'=>Auth::user()->id
        ]);

    }
    public function updateChat(Request $request)
    {
        if(empty($request->id) and empty($request->text)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        return Chats::find($request->id)->update(
            [
                'text'=>$request->text,
            ]
            );
        

    }
}
