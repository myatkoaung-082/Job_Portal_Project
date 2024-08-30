<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;
    protected $fillable = ['interview_date', 'interview_time', 'interview_location', 'job_apply_id'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
