<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bolim extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'b_id',
    ];
    public function child(){
        return $this->belongsTo("App\Models\Bolim",'id');
    }
   
    
}
