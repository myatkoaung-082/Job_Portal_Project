<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class professional_title extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_title_name',
        'category_id',
        'created_at',
        'updated_at'
    ];
}
