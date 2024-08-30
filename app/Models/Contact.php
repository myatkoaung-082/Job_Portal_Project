<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'seeker_id',
        'company_id',
        'created_at'
    ];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
