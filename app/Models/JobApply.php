<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    use HasFactory;
    protected $fillable = ['seeker_id','job_id','apply_date','created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
