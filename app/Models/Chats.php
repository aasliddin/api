<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'file',
        'view',
        'user_id',
        'message_id',
    ];
    public function user(){
        return $this->belongsTo("App\Models\User",'user_id');
    }
}
