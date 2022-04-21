<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id', 'sum', 'balance', 'promo_balance'
    ];
    protected $casts = [
        'done' => 'boolean',
    ];

    protected $appends = [
         'formatted_created_at',
    ];

    public function getFormattedCreatedAtAttribute() {
        return isset($this->attributes['created_at']) ? Carbon::parse($this->attributes['created_at'])->format('d.m.Y') : null;
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
