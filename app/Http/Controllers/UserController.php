<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // return $user;
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'exror' => ['Parol login xato']
                ], 401);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function register(Request $request){
        if(empty($request->name)){
            return response()->json([
                'msg'=> "Name empty"
            ], 422);        
        }
        if(strlen($request->name)<3){
            return response()->json([
                'msg'=> "Name 3tadan kam belgi"
            ], 422);        
        }
        $q=  explode('@',$request->email);
        if(empty($request->email) or $q[count($q)-1]!='jbnuu.uz'){
            return response()->json([
                'msg'=> "email xato"
            ], 422);        
        }
        if(!empty(User::where('email',$request->email)->first())){
            return response()->json([
                'msg'=> "email allaqachon ro'yxattan o'tgan "
            ], 422);        
        }
        $name='';
        if(!empty($request->photo)){
            $name=  time().".".$request->photo->extension();
            $a =  $request->photo->move(public_path('uploads/'), $name);
            $name="uploads/".$name;
        }
       
        $data = [
            "name" => $request->name,
            "fam" => $request->fam,
            "sh" => $request->sh,
            "phone" => $request->phone,
            "bolim_id" => $request->bolim_id,
            "lavozim" => $request->lavozim,
            "photo" => $name,
            "role" => $request->role??"1",
            "email" => $request->email,
        ];
        // return $data;
        $p = $request->password;
        $p_r = $request->return_password;
        if($p != "" || $p_r != ""){
            if($p != $p_r){
                return response()->json([
                    'msg'=> "You entered two password differently"
                ], 422);        
            }
            $password = bcrypt($request->password);
            $data["password"] = $password;
        } 
        
        $user = User::create($data);
        return $user;
    }
}
