<?php

namespace App\Console;

<<<<<<< HEAD

use App\Console\Commands\UpdateOrderStatus;
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
<<<<<<< HEAD
{   
=======
{
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
<<<<<<< HEAD
       $schedule->command(UpdateOrderStatus::class)->dailyAt('00:00');
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
