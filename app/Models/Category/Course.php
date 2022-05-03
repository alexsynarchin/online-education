<?php

namespace App\Models\Category;

use App\Models\Comment\Comment;
use App\Models\EduChat;
use App\Models\Lesson\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'edu_type_id',
        'edu_level_id',
        'specialty_id',
        'direction_id',
        'subject_id',
        'author_id',
        'slug',
        'lessons_count',
        'yege'
    ];

    protected $casts = [
        'yege' => 'boolean',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('courses')
            ->singleFile()
            ->useDisk('course');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(240)
            ->crop(Manipulations::CROP_CENTER, 200, 240)
            ->nonQueued();
    }


    protected $appends = [
        'image','rating', 'price', 'user_buy', 'rating_count', 'unread_teacher_messages_count'
    ];
    public function getRatingAttribute()
    {
        $rating = 0;

        $comments_count = $this->comments()->where('active', 1)->where('rating', '>', 0)->count();
       if($comments_count > 0) {
           $sum = $this->comments()->where('active', 1)->where('rating', '>', 0)->sum('rating');
           $rating = $sum / $comments_count;
       }
        return round($rating, 0);
    }

    public function getUserBuyAttribute()
    {

        $result = false;
        if(\Auth::check()) {
            $user = \Auth::user();
            if($user  -> profile_type === 'student') {
                $result =  $this->lessons()->whereHas('students', function ($query) use ($user){
                    $query->where('student_id', $user -> studentAccount->id);
                }) -> exists();
            }
        }

        return $result;
    }

    public function getUnreadTeacherMessagesCountAttribute()
    {
        $count = $this->messages()->where('read', 0) ->where('sender_type', 'teacher') -> count();
        return $count;
    }

    public function getPriceAttribute()
    {
        $price = $this -> lessons -> sum('price_user');
        return $price;
    }
    public function getImageAttribute()
    {
        $image = $this ->getFirstMediaUrl('courses','thumb');
        return $image;
    }
    public function getRatingCountAttribute()
    {
        $comments_count = $this->comments()->where('active', 1)->where('rating', '>', 0)->count();
        return $comments_count;
    }
    public function author()
    {
        return $this -> belongsTo(User::class, 'author_id');
    }
    public function direction()
    {
        return $this->belongsTo(CategoryType::class,'direction_id');
    }

    public function specialty()
    {
        return $this->belongsTo(CategoryType::class, 'specialty_id');
    }

    public function edu_type()
    {
        return $this -> belongsTo(CategoryType::class, 'edu_type_id');
    }
    public function subject()
    {
        return $this -> belongsTo(CategoryType::class, 'subject_id');
    }
    public function level()
    {
        return $this -> belongsTo(CategoryType::class, 'edu_level_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }

    public function themes()
    {
        return $this->belongsToMany(CategoryType::class, 'course_theme', 'course_id', 'theme_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function messages()
    {
        return $this->morphMany(EduChat::class, 'educationable');
    }
}
