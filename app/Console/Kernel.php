<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Themosis\Core\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Console commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('publish:future-posts')->twiceDaily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
