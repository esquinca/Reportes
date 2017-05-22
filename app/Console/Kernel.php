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
        // Commands\Inspire::class,
        Commands\estadoserver::class,
        Commands\usuarioxdia::class,
        Commands\bytesxdia::class,
        Commands\mostapxdia::class,
        Commands\roguedevices::class,
        Commands\wlanxdia::class,
        Commands\recbytesxdia::class,
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
        $schedule->command('estado:server')->daily();
        $schedule->command('usuario:dia')->daily();
        $schedule->command('rebytes:dia')->daily();
        $schedule->command('bytes:dia')->daily();
        $schedule->command('ap:dia')->daily();
        $schedule->command('wlan:dia')->daily();
        $schedule->command('rougue:mes')->monthly();
    }
}
