<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_name',
        'created_at',
        'updated_at'
    ];
}
