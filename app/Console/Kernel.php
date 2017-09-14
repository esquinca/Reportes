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
        Commands\ResetEncxmes::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        //$schedule->command('estado:server')->daily();
        //$schedule->command('usuario:dia')->daily();
        //$schedule->command('rebytes:dia')->daily();
        //$schedule->command('bytes:dia')->daily();
        //$schedule->command('ap:dia')->daily();
        //$schedule->command('wlan:dia')->daily();
        //$schedule->command('rougue:mes')->monthly();

        $schedule->command('estado:server')->dailyAt('11:10');
        $schedule->command('usuario:dia')->dailyAt('11:13');
        $schedule->command('rebytes:dia')->dailyAt('11:20');
        $schedule->command('bytes:dia')->dailyAt('11:30');
        $schedule->command('ap:dia')->dailyAt('11:40');
        $schedule->command('wlan:dia')->dailyAt('11:50');
        $schedule->command('rougue:mes')->monthly();
        $schedule->command('reset:enc')->monthlyOn(28,'21:00');
    }
}
