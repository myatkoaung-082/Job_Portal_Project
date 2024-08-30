<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class seeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'available_status',
        'profile_image',
        'phone',
        'dob',
        'address',
        'gender',
        'martial_status',
        'nrc',
        'resume',
        'city_id',
        'professional_title_id',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
