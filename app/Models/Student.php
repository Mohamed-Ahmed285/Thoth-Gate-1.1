<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];
    protected $table = 'students';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function purchased_lectures()
    {
        return $this->hasMany(Purchased_Lectures::class);
    }
    public function exam_sessions()
    {
        return $this->hasMany(ExamSession::class);
    }
}
