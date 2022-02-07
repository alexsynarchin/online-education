<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Message extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $fillable=[
        'chat_id', 'text', 'read'
    ];
    protected $appends = [
        'formatted_date','user_avatar', 'user_full_name'
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
    public function messagable()
    {
        return $this -> morphTo();
    }
    public function chat()
    {
        return $this->belongsTo(Chat::class,'chat_id');
    }
}
