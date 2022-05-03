<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'educationable_id', 'educationable_type', 'sender_id',
        'recipient_id', 'text', 'read', 'cansel_reason',
    ];

    public function educationable()
    {
        return $this->morphTo();
    }
}
