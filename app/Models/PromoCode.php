<?php

namespace App\Models;

use App\Models\Account\StudentAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $casts = [
        'start_time'  => 'date:m-d-Y',
        'end_time' => 'date:m-d-Y',
    ];

    public function studentAccounts() {
        return $this->belongsToMany(StudentAccount::class, 'student_promo','promo_id'  ,'student_id');
    }
}
