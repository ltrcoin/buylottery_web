<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateResultMegaMillionGame::class,
        UpdateResultEuroJackpotGame::class,
        UpdateResultAdminGame::class
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
        // updated result game mega millions 23:00 EST - Tuesdays and Fridays
        /*$schedule->command('api:updateResultMegaMillionGame')
        ->cron('* 6 * * 3,6')
        ->timezone('UTC');*/
        $schedule->command('api:updateResultMegaMillionGame')
        ->weekly()
        ->tuesdays()
        ->at('23:30')
        ->timezone('EST');

        $schedule->command('api:updateResultMegaMillionGame')
        ->weekly()
        ->fridays()
        ->at('23:30')
        ->timezone('EST');

        // updated result game eurojackpot 19:00 GMT Fridays
        $schedule->command('api:updateResultEuroJackpotGame')
        ->weekly()
        ->fridays()
        ->at('19:30')
        ->timezone('UTC');

        /*$schedule->command('api:updateResultAdminGame')
        ->daily()
        ->timezone('UTC')
        ->when(function() {
            $game = Game::where('id_game_api', '')->first();
            if($game) {
                $hour = $game->draw_time;
                $weekdays = explode(',', $game->draw_day);
                if(in_array(date('w', time()), $weekdays) && $game->draw_time == date('H:i', time())) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        });*/


        /*$schedule->call(function() {

        })->daily()->when(function() {
            $weekdays = [];
            $rs = Game::where()
            $today = Carbon::today();
            return in_array($today->day, $days); 
        });*/



    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
