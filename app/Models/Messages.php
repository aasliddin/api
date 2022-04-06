<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'user_id',
        'status',
    ];
    public function user(){
        return $this->belongsTo("App\Models\User",'user_id');
    }
    public function reyting(){
        return $this->belongsTo("App\Models\Reyting",'id','messages_id');
    }
    public function manager(){
        return $this->belongsTo("App\Models\Status",'id','messages_id');
    }
}