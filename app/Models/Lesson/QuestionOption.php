<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class QuestionOption extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable =[
        'question_id', 'right_answer', 'text', 'menuindex'];
    protected $casts = [
        'right_answer' => 'boolean',
        'answer' => 'boolean'

    ];
    protected $appends = [
        'answer','preview'
    ];
    public function getPreviewAttribute()
    {
        $image = $this ->getFirstMediaUrl('question_options','thumb');
        return $image;
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('question_options')
            ->singleFile()
            ->useDisk('question_option');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(220)
            ->height(240)
            ->crop(Manipulations::CROP_CENTER, 220, 240)
            ->nonQueued();
    }

    public function getAnswerAttribute(){
        return false;
    }

    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }
}
