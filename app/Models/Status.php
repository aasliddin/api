<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'user_id',
        'messages_id',
    ];
    public function message(){
        return $this->belongsTo("App\Models\Messages",'messages_id');
    }
    public function user(){
        return $this->belongsTo("App\Models\User",'user_id');
    }
}
