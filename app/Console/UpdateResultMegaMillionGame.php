<?php

/**
 * @Author: KEN
 * @Date:   2018-08-19 20:57:28
 * @Last Modified by:   KEN
 * @Last Modified time: 2018-08-23 09:50:30
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

class UpdateResultMegaMillionGame extends Command
{
	protected $signature = 'api:updateResultMegaMillionGame';

	protected $description = 'Update result mega millions game';

    public function handle()
    {
        $game = Game::where('id_game_api', Game::MEGAMILLION_ID)->first();
        if($game) {
            try {
            	$rs_api = $this->getResult();
                $rs_number = $rs_api['results'];
                $win_number = array_map(
                	function($val) {
						return (int) filter_var($val, FILTER_SANITIZE_NUMBER_INT);
					}, 
					array_slice($rs_number, 0, $game->numbers)
				);

                $win_special = array_map(
                	function($val) {
						return (int) filter_var($val, FILTER_SANITIZE_NUMBER_INT);
					}, 
					array_slice($rs_number, $game->numbers, $game->special_numbers)
				);

                \DB::beginTransaction();
                $win = new WinningNumber();
                $win->game_id = $game->id;
                $win->draw_date = $rs_api['draw'];
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
                //update info game
                /*$info = $this->getInfo();
                $game->name = $info['name'];
                $game->min_number = $info['main_min'];
                $game->max_number = $info['main_max'];
                $game->numbers = $info['main_drawn'];
                $game->min_special = $info['bonus_min'];
                $game->max_special = $info['bonus_max'];
                $game->special_numbers = $info['bonus_drawn'];
                $game->save();*/

                \DB::commit();
            } catch(Exception $e) {
                \DB::rollBack();
            }
        }
    }

    public function getResult($data = []) {
    	if(count($data) > 0) {
    		return $data;
    	}
    	try {
	    	$client = new Client();
	    	//get info mega millions game
	        $params_mega = [
	            'query' => [
	                'api_key' => env('KEY_API_MAGAYO', 'hXJDjsp8I6RY'),
	                'game' => Game::MEGAMILLION_ID,
	                'format' => 'json'
	            ]
	        ];
	        $response_mega = $client->request('GET',  env('URL_API_RESULT_MAGAYO', ''), $params_mega );
	        $body_mega = json_decode($response_mega->getBody()->getContents());
	        if($body_mega->error == 0) {
	        	$data = [
                    'results' => explode(',',$body_mega->results),
                    'draw' => $body_mega->draw
                ];
	        }
	    } catch(Exception $e) {
	    	$data = [];
	    }
        return $this->getResult($data);
    }

    public function getInfo() {
    	if(count($data) > 0) {
    		return $data;
    	}
    	try {
	    	$client = new Client();
	    	//get info mega millions game
	        $params = [
	            'query' => [
	                'api_key' => env('KEY_API_MAGAYO', 'hXJDjsp8I6RY'),
	                'game' => Game::MEGAMILLION_ID,
	                'format' => 'json'
	            ]
	        ];
	        $response = $this->client->request('GET',  env('URL_API_INFO_MEGA', ''), $params );
	        $body = json_decode($response->getBody()->getContents());
	        if($body['error'] == 0) {
	        	$data = [
	        		'error' => $body->error,
				    'name' => $body->name,
				    'country' => $body->country,
				    'state' => $body->state,
				    'main_min' => $body->main_min,
				    'main_max' => $body->main_max,
				    'main_drawn' => $body->main_drawn,
				    'bonus_min' => $bonus_min,
				    'bonus_max' => $body->bonus_max,
				    'bonus_drawn' => $body->bonus_drawn,
				    'same_balls' => $body->same_balls,
				    'digits' => $body->digits,
				    'drawn' => $body->drawn,
				    'is_option' => $body->is_option,
				    'option_desc' => $body->option_desc
	        	];
	        }
	    } catch(Exception $e) {
	    	$data = [];
	    }
        return $this->getInfo($data);
    }
}