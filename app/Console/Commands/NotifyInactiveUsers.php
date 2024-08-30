<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\InactiveUserNotification;

class NotifyInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notify-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users who haven\'t logged in for 3 months.';

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
         // Get the date 3 months ago
         $threeMonthsAgo = Carbon::now()->subMonths(3);

         // Find users who haven't logged in for 3 months
         $inactiveUsers = User::where('last_login_at', '<', $threeMonthsAgo)
                              ->whereNull('notified_at')
                              ->get();
 
         foreach ($inactiveUsers as $user) {
             if(is_null($user->notified_at)){
                 // Send email notification
             Mail::to($user->email)->send(new InactiveUserNotification($user));
             }
 
             // Update the notified_at column
             $user->notified_at = Carbon::now();
             $user->save();
             
         }
 
         $this->info('Inactive users have been notified.');
        return Command::SUCCESS;
    }
}
