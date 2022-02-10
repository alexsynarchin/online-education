<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Message extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $fillable=[
        'chat_id', 'text', 'read',
    ];
    protected $appends = [
        'formatted_date','user_avatar', 'user_full_name', 'files'
    ];
    public function getUserFullNameAttribute()
    {
        $name =  $this->messagable -> name;
        $surname = $this -> messagable -> surname;
        return $name . ' ' . $surname;
    }
    public function getUserAvatarAttribute()
    {
        return $this->messagable->avatar;
    }
    public function getFormattedDateAttribute() {
        $date = $this->attributes['created_at'];
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('H:i d.m.Y');
        return $date;
    }
    public function getFilesAttribute()
    {
        $mediaGallery = $this ->getMedia('messages');
        $media = [];
        foreach ($mediaGallery as $image) {
            array_push($media, [
                'id' => $image['id'],
                'name' => $image['file_name'],
                'url' => $image -> getUrl(),

            ]);
        }
        return $media;
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('messages')
            ->useDisk('message');
    }

    public function messagable()
    {
        return $this -> morphTo();
    }
    public function chat()
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }
}
