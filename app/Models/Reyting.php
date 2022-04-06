<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reyting extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'ball',
        'messages_id',
    ];
    public function message(){
        return $this->belongsTo("App\Models\Messages",'messages_id');
    }
}