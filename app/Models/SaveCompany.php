<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveCompany extends Model
{
    use HasFactory;
    protected $fillable = ['seeker_id', 'company_id'];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
