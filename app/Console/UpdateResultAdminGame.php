<?php

/**
 * @Author: KEN
 * @Date:   2018-08-19 20:57:28
 * @Last Modified by:   KEN
 * @Last Modified time: 2018-08-20 09:21:19
 */
namespace App\Console;

use Illuminate\Console\Command;
use App\Http\Models\Backend\Game;
use App\Http\Models\Backend\WinningNumber;
use App\Http\Models\Backend\Ticket;
use App\Http\Models\Backend\Prize;
use App\Http\Models\Backend\Winner;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Helpers\Number;

class UpdateResultAdminGame extends Command
{
	protected $signature = 'api:updateResultAdminGame';

	protected $description = 'Update result Admin game';

    public function handle()
    {
        $game = Game::where('id_game_api', '')->first();
        if($game) {
            try {
                $win_number = Number::getRandomSet( range($game->min_number, $game->max_number), $game->numbers);
                $win_special = Number::getRandomSet(range($game->min_special, $game->max_special), $game->special_numbers);
                \DB::beginTransaction();
                $win = new WinningNumber();
                $win->game_id = $game->id;
                $win->draw_date = date('Y-m-d', time());
                $win->numbers = implode(',', $win_number);

                if($game->has_special_number) {
                    $win->special_numbers = implode(',', $win_special);
                }
                if($win->save()) {
                    $tickets = Ticket::where('game_id', $game->id)
                                    ->where('status', Ticket::WARNING)
                                    ->get();
                    foreach ($tickets as $ticket) {
                        //update status ticket
                        Ticket::where('id', $ticket->id)->update(['status' => Ticket::COMPLETED]);

                        $check_number = array_intersect(explode(',', $ticket->numbers), $win_number);
                        $check_special = array_intersect(explode(',', $ticket->special_numbers), $win_special);
                        $check_prize = Prize::where('game_id', $game->id)
                                            ->where('match', count($check_number))
                                            ->where('match_special', count($check_special))
                                            ->first();
                        if($check_prize) {
                            $winner = new Winner();
                            $winner->user_id = $ticket->user_id;
                            $winner->game_id = $ticket->game_id;
                            $winner->ticket_id = $ticket->id;
                            $winner->prize_id = $check_prize->id;
                            $winner->winning_number_id = $win->id;
                            $winner->status = Winner::WARNING;
                            $winner->save();
                        }
                    }
                }

                \DB::commit();
            } catch(Exception $e) {
                \DB::rollBack();
            }
        }
    }
}