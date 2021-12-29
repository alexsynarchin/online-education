<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model implements HasMedia
{
    use HasFactory,  InteractsWithMedia;

    protected $fillable=[
        'test_id', 'text', 'menuindex','directory', 'image'
    ];
    protected $appends =[
        'preview'
    ];

    public function getPreviewAttribute()
    {
        $image = $this ->getFirstMediaUrl('questions','thumb');
        return $image;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('questions')
            ->singleFile()
            ->useDisk('question');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(220)
            ->height(240)
            ->crop(Manipulations::CROP_CENTER, 220, 240)
            ->nonQueued();
    }
    public function test(){
        return $this -> belongsTo(Test::class, 'test_id' );
    }

    public function options(){
        return $this->hasMany(QuestionOption::class, 'question_id');
    }
}
