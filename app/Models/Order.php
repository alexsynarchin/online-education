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
    protected $fillable = ['student_id', 'status', 'buying_id', 'money', 'bonus'];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'order_lesson', 'order_id', 'lesson_id');
    }

    protected $appends = [
        'formatted_created_at', 'name', 'student'
    ];

    public function getFormattedCreatedAtAttribute() {
        return isset($this->attributes['created_at']) ? Carbon::parse($this->attributes['created_at'])->format('d.m.Y') : null;
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function studentAccount()
    {
        return $this->belongsTo(Account\StudentAccount::class, 'student_id');
    }
    public function getStudentAttribute()
    {
        return $this->studentAccount->user;
    }
    public function getNameAttribute()
    {
        $name='';
        if($this->attributes['type'] === 'course') {
            if(Course::where('id', $this->attributes['buying_id']) -> exists()) {
                $course = Course::findOrFail($this->attributes['buying_id']);
                $name = $course->title;
            }

        } else {
            if(Lesson::where('id', $this->attributes['buying_id']) -> exists()) {
                $lesson = Lesson::findOrFail($this->attributes['buying_id']);
                $name = $lesson->title;
            }
        }
        return $name;
    }
}
