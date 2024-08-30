<?php

namespace App\Actions\Fortify;

use Carbon\Carbon;
use App\Models\User;
use App\Models\seeker;
use App\Models\employer;
use App\Models\VerifyToken;
use App\Mail\activationMail;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User  //array $input
    {
        
        Validator::make($input,[
            'name' => ['required', 'string', 'max:255'],  
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
            'password' => ['required'],
            'confirm-password' => ['required','same:password'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        
        if($input['role'] == 'seeker'){
            seeker::create([
                'email' => $input['email'],
                'available_status' => '1',
                'created_at' => Carbon::now()
            ]);
        }elseif($input['role'] == 'employer'){
            employer::create([
                'email' => $input['email'],
                'created_at' => Carbon::now()
            ]);
        }

        $otp_token = rand(10,100..'2024');
        $get_otp = new VerifyToken();
        $get_otp->token = $otp_token;
        $get_otp->email = $input['email'];
        $get_otp->save();

        $get_user_email = $input['email'];
        Mail::to($input['email'])->send(new activationMail($get_user_email,$otp_token));

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'role' => $input['role'],
            'password' => Hash::make($input['password']),
            'created_at' => Carbon::now()
        ]);

        
    }
}
