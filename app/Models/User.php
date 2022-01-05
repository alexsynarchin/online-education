<?php

namespace App\Models;

use App\Models\Account\StudentAccount;
use App\Models\Account\TeacherAccount;
use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use App\Models\Reference\EduInstitution;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = [
        'profile_type', 'subjects'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfileTypeAttribute()
    {
        $profile_type = '';
        if($this->hasRole('teacher')) {
            $profile_type = 'teacher';
        }
        if($this->hasRole('student')) {
            $profile_type = 'student';
        }
        return $profile_type;
    }
    public function getSubjectsAttribute()
    {
        $subjects = [];
        if($this -> teacherCourses() -> exists()) {
            $courses = $this ->teacherCourses() ->with('subject') ->get(['id', 'subject_id']);
            foreach ($courses as $course) {
                $check = array_search(($course -> subject -> title), $subjects);
                if($check === false) {
                    $subjects[] = $course->subject->title;
                }
            }
            return $subjects;
        }
    }
    public function studentAccount(){
        return $this -> hasOne(StudentAccount::class,'user_id');
    }

    public function teacherAccount(){
        return $this -> hasOne(TeacherAccount::class,'user_id');
    }
    public function eduInstitutions()
    {
        return $this -> belongsToMany(EduInstitution::class, 'user_edu_institution');
    }
    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'author_id');
    }
}
