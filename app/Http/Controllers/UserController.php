<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Verify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    

    function index(Request $request)
    {
        $user= User::where('email', $request->email)->with('bolim')->first();
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
        if(Verify::where('email',$request->email??"")->where('token',$request->token)->count()>0){
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
                "email" => $request->email,
            ];
            if($request->bolim_id==23){
                $data["role"]=2;
            }
            else{
                $data["role"]=$request->role??1;
            }
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
        return response()->json(
            ['status'=>0]
        , 422);
    }
    public function update(Request $request){
        if(strlen($request->name)<3 and strlen($request->fam)<3 and strlen($request->phone)<7 and !empty($request->bolim_id)<3  and strlen($request->sh)<3 and strlen($request->lavozim)<3){
            return response()->json([
                'msg'=> "3tadan kam belgi"
            ], 422);        
        }
       
        $name=Auth::user()->photo??"";
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
        ];
        $p = $request->oldpassword;
        if(!empty($request->newpassword)){
            $user= User::where('email',Auth::user()->email)->with('bolim')->first();
            
            if(Hash::check($request->oldpassword, $user->password )){
                $data["password"] = bcrypt($request->newpassword);
            }
            else{
                return response()->json(
                    ['password'=>'error password']
                , 422); 
            }
        }
        $user = User::find(Auth::user()->id)->update($data);
        if($user){
            return response()->json(
                ['succes'=>"ok"]
            , 200); 
        }
        return response()->json(
            'error'
        , 422);
    }
    public function getme()
    {
        $user=User::where('email',Auth::user()->email)->with('bolim')->first();
        $app_version=[
            "type"=> 1,
            "version"=> 1,
            "release"=> "1.0.0",
            "name"=> null,
            "description"=> null
        ];
        return response()->json(
            ['user'=>$user,'app_version'=>$app_version]
        , 200);  
    }
    public function forget(Request $request)
    {
        if(empty($request->email))
        return response()->json(
            ['response'=>"email"]
        , 200); 
        
        $token=time()."";
        $token=$token[strlen($token)-1].$token[strlen($token)-2].$token[strlen($token)-3].$token[strlen($token)-4];
        if(User::where('email', $request->email)->count()>0){
            User::where('email', $request->email)->update(
                [
                    'remember_token'=>$token
                ]
            );
            $details=[
                'title'=>"Bu ko'd parol tiklash uchun ",
                'body'=>"Bu ko'dni hechkimga bermang ",
                'token'=>$token
            ];
    
            Mail::to($request->email)->send(new TestMail($details));
            return response()->json(
                ['response'=>"succes"]
            , 200); 
        }
        else{
            return response()->json(
                ['response'=>"error"]
            , 200); 
        }
    }
    public function repeat(Request $request)
    {
        $a = User::where('email',$request->email)->first();
        if(empty($a)){
        return response()->json(
            ['response'=>"email"]
        , 200); 
        }
       
        if($request->verify_code!=$a->remember_token)
        return response()->json(
            ['response'=>"verify code"]
        , 200); 
        
        return User::where('email',$request->email)->where('remember_token',$request->verify_code)->update(
            [
                'password'=>bcrypt($request->password),
                'remember_token'=>""
            ]
        );
        
    }
    public function verify(Request $request)
    {
    
        $token=time()."";
        $token=$token[strlen($token)-1].$token[strlen($token)-2].$token[strlen($token)-3].$token[strlen($token)-4];
        if(Verify::where('email', $request->email)->count()>0){
            Verify::where('email', $request->email)->update(
                [
                    'token'=>$token
                ]
            );
        }
        else{
            Verify::create(
                [
                    'email'=>$request->email,
                    'token'=>$token
                ]
            ); 
        }
        $details=[
            'title'=>"Ro'yxatdan o'tish paroli  ",
            'body'=>"Bu ko'dni hechkimga bermang ",
            'token'=>$token
        ];

        Mail::to($request->email)->send(new TestMail($details));
        return response()->json(
            ['response'=>"succes"]
        , 200); 
        
       
    }
}
