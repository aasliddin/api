<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'title',
        'user_id',
        'worker_id',
        'status',
        'ball',
    ];
    public function user(){
        return $this->belongsTo("App\Models\User",'user_id');
    }
    public function worker(){
        return $this->belongsTo("App\Models\User",'worker_id');
    }
    public function chat(){
        return $this->hasMany("App\Models\Chats",'message_id');
    }
    
}
