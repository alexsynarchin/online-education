<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['test_result_id', 'question_id', 'option_id', 'correct'];
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
