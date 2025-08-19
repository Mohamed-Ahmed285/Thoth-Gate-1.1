<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $guarded = [];
    protected $table = 'lectures';
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
