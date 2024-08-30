<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\seeker;
use App\Models\Contact;
use App\Models\employer;
use App\Models\JobApply;
use App\Models\Purchase;
use App\Models\Interview;
use App\Models\SaveCompany;
use Illuminate\Console\Command;
use App\Models\SkillandLanguage;
use App\Models\companyIndustries;
use App\Models\EmploymentHistory;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDeletedNotification;
use App\Models\EducationalQualification;

class DeleteInactiveSeekerAndCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-inactive-seeker-company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who have not logged in for 1 months.';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        // Get the date 4 months ago
        $oneMonthsAgo = Carbon::now()->subMonths(4);

        // Find users who haven't logged in for 4 months and are soft deleted
        $usersToDelete = User::where('last_login_at', '<', $oneMonthsAgo)
                       ->whereIn('role', ['seeker', 'employer'])
                       ->get();

        foreach ($usersToDelete as $user) {
            // Send email notification before deleting
            Mail::to($user->email)->send(new UserDeletedNotification($user));

            if($user->role == 'seeker'){
               Interview::leftJoin('job_applies','job_applies.id','interviews.job_apply_id')
               ->where('job_applies.seeker_id',$user->id)
               ->delete();
               JobApply::where('seeker_id', $user->id)->delete();
               EducationalQualification::where('seeker_id', $user->id)->delete();
               EmploymentHistory::where('seeker_id', $user->id)->delete();
               SkillandLanguage::where('seeker_id', $user->id)->delete();
               SaveCompany::where('seeker_id',$user->id)->delete();
               Contact::where('seeker_id', $user->id)->delete();
               seeker::where('email',$user->email)->delete();

           }elseif($user->role == 'employer'){
               JobApply::select('job_applies.*')
                   ->leftJoin('jobs', 'jobs.id', 'job_applies.job_id')
                   ->leftJoin('company_industries', 'company_industries.id', 'jobs.company_industry_id')
                   ->where('company_industries.company_id', $user->id)
                   ->delete();

               Job::select('jobs.*')
                   ->leftJoin('company_industries', 'company_industries.id', 'jobs.company_industry_id')
                   ->where('company_industries.company_id', $user->id)
                   ->delete();

               companyIndustries::where('company_id', $user->id)->delete();
               TransactionHistory::where('company_id', $user->id)->delete();
               Purchase::where('company_id', $user->id)->delete();
               Contact::where('company_id', $user->id)->delete();
               employer::where('email', $user->email)->delete();

           }

            // Delete the user
            $user->forceDelete();
        }

        $this->info('Inactive users have been deleted.');
        return Command::SUCCESS;
    }
}
