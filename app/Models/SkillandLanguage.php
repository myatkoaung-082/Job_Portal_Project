<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillandLanguage extends Model
{
    use HasFactory;
    protected $fillable = ['skill_name','skill_level','seeker_id','updated_at','created_at'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
