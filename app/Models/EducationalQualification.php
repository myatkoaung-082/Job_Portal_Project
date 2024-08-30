<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalQualification extends Model
{
    use HasFactory;
    protected $fillable = ['institute_name','degree_level','area_of_studies','passing_year','seeker_id','created_at','updated_at'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
