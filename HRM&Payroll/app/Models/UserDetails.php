<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = ['profile', 'about_me'];

    public function user(){
        $this->belongsTo(User::class);
    }
}
