<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id','name'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function expense(){
        return $this->hasMany(Expense::class);
    }


}
