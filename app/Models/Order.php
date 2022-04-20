<?php

namespace App\Models;

use App\Models\Category\Course;
use App\Models\Lesson\Lesson;
use Carbon\Carbon;
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

    protected $appends = [
        'formatted_created_at', 'name'
    ];

    public function getFormattedCreatedAtAttribute() {
        return isset($this->attributes['created_at']) ? Carbon::parse($this->attributes['created_at'])->format('d.m.Y') : null;
    }
    public function getNameAttribute()
    {
        $name='';
        if($this->attributes['type'] === 'course') {
            $course = Course::findOrFail($this->attributes['buying_id']);
            $name = $course->title;
        }
        return $name;
    }
}
