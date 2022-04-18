<?php

namespace App\Models\Lesson;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;
    protected $table = 'test_results';
    protected $fillable = ['test_id', 'user_id', 'test_result'];
    public function answers()
    {
        return $this->hasMany(TestResultAnswer::class,'test_result_id');
    }


}
