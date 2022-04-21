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
                $mes=Messages::where('user_id',Auth::user()->id)->with('worker.bolim')->with('user.bolim')->get();
                return response()->json(
                    $mes
                , 200);
            }
        $mes=Messages::with('user.bolim')->with('worker.bolim')->get();
        return response()->json(
            $mes
        , 200);

    }

    public function gettMessage($id)
    {
        if(Auth::user()->role==1)
            {
                $mes=Messages::where('user_id',Auth::user()->id)->where('status',$id)->with('worker.bolim')->with('user.bolim')->withCount('chat')->get();
                return response()->json(
                    $mes
                , 200);
            }
        if(Auth::user()->role==2)
        {
            $mes=Messages::where('worker_id',Auth::user()->id)->where('status',$id)->with('worker.bolim')->with('user.bolim')->withCount('chat')->get();
            return response()->json(
                $mes
            , 200);
        }
        $mes=Messages::with('user.bolim')->where('status',$id)->with('worker.bolim')->with('user.bolim')->withCount('chat')->get();
        return response()->json(
            $mes
        , 200);

    }
    public function createMessage(Request $request)
    {
        if(empty($request->text) and empty($request->title)){
            return response()->json([
                'msg'=> "Text empty"
            ], 422);        
        }
        if(strlen($request->text)<3){
            return response()->json([
                'msg'=> "Text 3tadan kam belgi"
            ], 422);        
        }
        $name="";
        if(!empty($request->photo)){
            $name=  time().".".$request->photo->extension();
            $a =  $request->photo->move(public_path('meassage/'), $name);
            $name="meassage/".$name;
        }
        return Messages::create(
            [
                'title'=>$request->title,
                'text'=>$request->text,
                'url'=>$name,
                'user_id'=>Auth::user()->id
            ]
        );
    }
    public function updateMessage(Request $request)
    {
        if(empty($request->text) and empty($request->title)){
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
                'title'=>$request->title,
                'text'=>$request->text,
            ]
        ))
        return Messages::find($request->id);
        return  response()->json([
            'msg'=> "xato"
        ], 422);  
    }
    public function activeMessage(Request $request)
    {
        if(empty($request->message_id)){
            return response()->json([
                'msg'=> " id empty"
            ], 422);        
        }
        if(empty(Messages::find($request->message_id)->worker_id))
        if(Messages::find($request->message_id)->update(
            [
                'worker_id'=>Auth::user()->id,
                'status'=>'1'
            ]
            ))
            return  response()->json('succes', 200);  

            return  response()->json('Allaqachon olib bo\'lingan', 422);   

    }
    public function ball()
    {
        if(empty($request->id) and empty($request->text) and empty($request->ball)){
            return response()->json([
                'msg'=> "empty"
            ], 422);        
        }
        
        if(Messages::find($request->id)->update(
            [
                'izoh'=>$request->text,
                'status'=>'2',
                'ball'=>$request->ball
            ]
            ))
            return  response()->json('succes', 200);  
            return  response()->json('error', 422);  
    }
}
