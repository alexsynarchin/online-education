<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class EduChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'educationable_id', 'educationable_type', 'sender_id',
        'recipient_id', 'text', 'read', 'cansel_reason', 'sender_type'
    ];
    protected $appends = [
        'formatted_date','user_avatar', 'user_full_name'
    ];
    public function educationable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function getUserAvatarAttribute()
    {
        return $this->user->avatar;
    }

    public function getUserFullNameAttribute()
    {
        $name =  $this->user -> name;
        $surname = $this -> user -> surname;
        return $name . ' ' . $surname;
    }
    public function getFormattedDateAttribute() {
        $date = $this->attributes['created_at'];
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('H:i d.m.Y');
        return $date;
    }
}
