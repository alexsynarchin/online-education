<?php

namespace App\Models\Account;

use App\Models\Lesson\Lesson;
use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'student_lesson', 'student_id', 'lesson_id')->withTimestamps();
    }

    public function promoCodes()
    {
        return $this->belongsToMany(PromoCode::class, 'student_promo' ,'student_id', 'promo_id' );
    }

    public function teachers()
    {
        return $this->belongsToMany(TeacherAccount::class, 'teacher_student', 'student_id', 'teacher_id');
    }
}
