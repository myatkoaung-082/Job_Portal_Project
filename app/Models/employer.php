<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'logo',
        'website',
        'company_phone',
        'number_of_employees',
        'address',
        'company_description',
        'city_id',
        'founder_name',
        'founded_date',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
