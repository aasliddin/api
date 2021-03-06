<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\Chats;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $mes = Messages::find($request->message_id);
        $mes->text=$mes->text." ";
        $mes->save();
        $mes = Messages::find($request->message_id);
        $mes->text=trim($mes->text);
        $mes->save();
        $name="";
        if(!empty($request->photo)){
            $name=  time().".".$request->photo->extension();
            $a =  $request->photo->move(public_path('chat/'), $name);
            $name="chat/".$name;
        }
        return Chats::create([
            'text'=>$request->text,
            'message_id'=>$request->message_id,
            'file'=>$name,
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
        $name="";
        if(!empty($request->photo)){
            unlink(public_path(Chats::find($request->id)->file));
            $name=  time().".".$request->photo->extension();
            $a =  $request->photo->move(public_path('chat/'), $name);
            $name="chat/".$name;
        }
        return Chats::find($request->id)->update(
            [
                'text'=>$request->text,
                'file'=>$name,
            ]
            );
        

    }
    public function active($id)
    {
        $a= Chats::where('message_id',$id)->where('user_id','!=',Auth::user()->id)->update(
            [
                'view'=>1
            ]
            );
            if($a){
                return response()->json([
                    "succes"
                ], 200);    
            }
            return response()->json([
                "error"
            ], 422);   
    }
}
