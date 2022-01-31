<?php

namespace App\Models\Account;

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function promoCodes()
    {
        return $this->belongsToMany(PromoCode::class, 'student_promo' ,'student_id', 'promo_id' );
    }
}
