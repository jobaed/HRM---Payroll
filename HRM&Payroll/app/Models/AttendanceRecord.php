<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model {
    protected $table = 'attendance_records';
    protected $fillable = ['user_id', 'clock_in', 'clock_out'];

    function user() {
        return $this->belongsTo( User::class );
    }



}
