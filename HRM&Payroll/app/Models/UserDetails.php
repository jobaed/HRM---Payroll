<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'profile','about_me', 'selary'];

    

    public function user() {
        $this->belongsTo( User::class );
    }
}
