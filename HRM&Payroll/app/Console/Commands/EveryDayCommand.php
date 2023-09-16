<?php

namespace App\Console\Commands;

use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Console\Command;

class EveryDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Will Insert EveryDay Null Attendence For Every User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Insert null attendance record for each user
            // Modify this code according to your database schema
            AttendanceRecord::create([
                'user_id' => $user->id,
                'clock_in' => null,
                'clock_out' => null,
            ]);
        }

        // $this->info('Null attendance records inserted successfully for all users at 10 AM.');
    }
}
