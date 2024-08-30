<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class township extends Model
{
    use HasFactory;

    protected $fillable = ['township_name','state_id'];
}
