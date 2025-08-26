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
    public function lectures()
    {
        return $this->hasMany(PurchasedLectures::class);
    }
    public function sessions()
    {
        return $this->hasMany(ExamSession::class);
    }
    public function messages()
    {
        return $this->hasMany(CommunityMessage::class);
    }
}
