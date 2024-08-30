<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_title_id',
        'company_industry_id',
        'work_type_id',
        'salary_type',
        'salary_range_id',
        'gender',
        'experience_level_id',
        'job_description',
        'job_requirement',
        'benefit',
        'apply_expire_date',
        'view_count',
        'vacancy',
        'age',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class)->onDelete('cascade');
    }
}
