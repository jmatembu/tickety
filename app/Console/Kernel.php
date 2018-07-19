<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
<<<<<<< HEAD
     * Register the commands for the application.
=======
     * Register the Closure based commands for the application.
>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
     *
     * @return void
     */
    protected function commands()
    {
<<<<<<< HEAD
        $this->load(__DIR__.'/Commands');

=======
>>>>>>> 4c338e88d2c42489fe577a3df730c3475deb532b
        require base_path('routes/console.php');
    }
}
