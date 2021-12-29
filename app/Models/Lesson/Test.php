<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = [
        'repeat_period',
        'complete_percent',
        'lesson_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class,'test_id');
    }
}
