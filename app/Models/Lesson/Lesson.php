<?php

namespace App\Models\Lesson;

use App\Models\Category\Course;
use App\Models\Chat;
use App\Models\EduChat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use VanOns\Laraberg\Traits\RendersContent;

class Lesson extends Model
{
    use HasFactory,  HasSlug, RendersContent;

    protected $fillable = [ 'title', 'course_id','price', 'time','user_id','status',
        'price_user','type_video','type_text','type_image', 'type_audio', 'slug', 'vk_url', 'youtube_url'];
    protected $appends = ['user_buy'];
    protected $casts = [
        'type_text' => 'boolean',
        'type_video' => 'boolean',
        'type_audio' => 'boolean',
        'type_image' => 'boolean',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'lesson_id');
    }

    public function author()
    {
        return $this -> belongsTo(User::class, 'author_id');
    }

    public function content(){
        return $this->hasOne(LessonContent::class, 'lesson_id');
    }

    public function getUserBuyAttribute()
    {

        $result = false;
        if(\Auth::check()) {
            $user = \Auth::user();
            if($user  -> profile_type === 'student') {
                $result =  $this->students()->where('student_id', $user -> studentAccount->id) -> exists();
            }
        }

        return $result;
    }

    public function students()
    {
        return $this
            ->belongsToMany(User::class, 'student_lesson','lesson_id','student_id')
            ->withTimestamps();
    }

    public function chat()
    {
        return $this->morphOne(Chat::class, 'chatable');
    }

    public function messages()
    {
        return $this->morphMany(EduChat::class, 'educationable');
    }
}
