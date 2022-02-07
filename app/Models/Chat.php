<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Chat extends Model
{
    use HasFactory;
    protected $table='chats';
    protected $fillable =[
        'teacher_id', 'sender_id', 'chat_type'
    ];
    protected $appends=['name','unread_count'];
    public function getNameAttribute()
    {
        return $this -> chatable -> title;
    }
    public function getUnreadCountAttribute()
    {
        $count = $this -> messages()->where('messagable_id','!=', Auth::user()->id)->where('read',false)->count();
        return $count;
    }
    public function chatable()
    {
        return $this->morphTo();
    }
    public function messages()
    {
        return  $this -> hasMany(Message::class, 'chat_id');
    }
}
