<?php

namespace App\Models;

use App\Models\Lesson\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'status', 'lesson_id'];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'order_lesson', 'order_id', 'lesson_id');
    }
}
