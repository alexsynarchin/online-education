<?php

namespace App\Models;

use App\Models\Account\StudentAccount;
use App\Models\Account\TeacherAccount;
use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use App\Models\Reference\EduInstitution;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory,InteractsWithMedia, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'phone',
        'gender',
        'city',
        'notifications'
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
        'profile_type', 'subjects', 'avatar', 'gender_string','formatted_birthday',
        'formatted_created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'notifications' => 'boolean',
    ];
    public function getGenderStringAttribute() {
        if(isset($this->gender)){
            $gender = $this->gender;
            if($gender == 1) {
                $genderString = 'Женский';
            } else {
                $genderString = 'Мужской';
            }
            return $genderString;
        } else {
            return "";
        }

    }

    public function getFormattedCreatedAtAttribute() {
        return isset($this->attributes['created_at']) ? Carbon::parse($this->attributes['created_at'])->format('d.m.Y') : null;
    }

    public function getFormattedBirthdayAttribute() {

        return isset($this->attributes['birthday']) ? Carbon::parse($this->attributes['birthday'])->format('d.m.Y') : null;
    }

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('users')
            ->singleFile()
            ->useDisk('user');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(240)
            ->height(240)
            ->crop(Manipulations::CROP_CENTER, 240, 240)
            ->nonQueued();
    }

    public function getAvatarAttribute()
    {
        $avatar = $this ->getFirstMediaUrl('users','thumb');
        if(!$avatar) {
            $avatar = '/images/avatar.jpg';
        }
        return $avatar;
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
        return $this -> belongsToMany(EduInstitution::class, 'user_edu_institution')->withPivot('main');
    }
    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    public function messages()
    {
        return $this -> morphMany(Message::class, 'messagable');
    }
}
