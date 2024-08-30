<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone',
        'role',
        'is_activated',
        'created_at',
        'updated_at'
    ];

    //seeker related data delete
    public function interviews(){
        return $this->hasMany(Interview::class);
    }
    public function jobApplies(){
        return $this->hasMany(JobApply::class);
    }
    public function educationalQualification(){
        return $this->hasMany(EducationalQualification::class);
    }
    public function employmentHistory(){
        return $this->hasMany(EmploymentHistory::class);
    }
    public function skillandLanguage(){
        return $this->hasMany(SkillandLanguage::class);
    }
    public function saveCompanies(){
        return $this->hasMany(SaveCompany::class);
    }
    public function contact(){
        return $this->hasMany(Contact::class);
    }
    public function seeker(){
        return $this->hasMany(seeker::class);
    }

    //company related data delete
    public function job(){
        return $this->hasMany(Job::class);
    }
    public function companyIndustry(){
        return $this->hasMany(companyIndustries::class);
    }
    public function transactionHistory(){
        return $this->hasMany(TransactionHistory::class);
    }
    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
    public function employer(){
        return $this->hasMany(employer::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
