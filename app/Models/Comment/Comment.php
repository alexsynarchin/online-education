<?php

namespace App\Models\Comment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Comment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable=[
        'name', 'email', 'comment', 'rating','user_id','parent_id',
    ];
    protected $casts = [
        'active' => 'boolean',
        'created_at' => "datetime:Y-m-d"
    ];
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this -> belongsTo(User::class, 'user_id');
    }
}
