<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Number;
use App\Http\Models\Backend\Game;
use App\Http\Models\Backend\Prize;
use App\Http\Models\Backend\WinningNumber;
use App\Http\Models\Backend\Ticket;
use App\Http\Models\Backend\Winner;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends BaseController
{
	// index of column in column list
	protected $defaultOrderBy = 0;
	protected $defaultOrderDir = 'desc';
	protected $model = Game::class;
	protected $module_name = 'game'; // tên dùng khi đặt tên route, ví dụ backend.task.index -> lấy tên `task`
	protected $messageName = 'msg_game'; // tên của flash message
	protected $listTitle = 'label.game.list_title';
	protected $initTableScript = 'backend.game.initTableScript';

	protected $buttons = [
		'createButton' => '/admin/game/add',
		'deleteButton' => '/admin/game/delete'
	];

	public function __construct( Container $app )
	{
		parent::__construct( $app );
		$this->fieldList = [
			[
				'name'        => 'id',
				'title'       => '#',
				'filter_type' => '#',
				'width'       => '2%'
			],
			[
				'name'        => 'name',
				'title'       => 'label.game.name',
				'filter_type' => 'text',
				'width'       => '30%',
			],
			[
				'name'        => 'draw_time',
				'title'       => 'label.game.draw_time',
				'filter_type' => '#',
				'width'       => '10%'
			],
			[
				'name'        => 'id_game_api',
				'title'       => 'label.game.draw_result',
				'className'   => 'text-center',
				'filter_type' => '#',
				'width'       => '8%'
			],
			[
				'name'        => '_',
				'title'       => '',
				'filter_type' => '#',
				'width'       => '8%'
			]
		];
	}

	public function _createIndexData( $items ) {
		$data = [];
		foreach ( $items as $item ) {
			$row = [];
			foreach ( $this->fieldList as $field ) {
				if ( array_key_exists( 'relation', $field ) ) {
					if ( $field['relation']['type'] == 1 ) {
						try {
							$row[] = $item->{$field['relation']['object']}->{$field['relation']['display']};
						} catch (\Exception $e) {
							Log::error($e->getMessage());
							$row[] = '';
						}
					} else {
						$row[] = implode( ', ', $item->{$field['relation']['object']}->pluck( $field['relation']['display'] )->all() );
					}

				} else {
					if ( $field['name'] == '_' ) {
						$row[] = 'x';
					} elseif($field['filter_type'] == 'date-range') {
						// display date data in localize format
						$row[] = Carbon::parse($item->{$field['name']})->format(__('label.date_format'));
					} else {
						$row[] = $item->{$field['name']};
					}
				}
			}

			$data[] = $row;
		}

		return $data;
	}

	public function add()
	{
		$data['buttons'] = [
			'saveButton' => true,
			'backButton' => route( 'backend.game.index' )
		];

		return view( 'backend.game.add', $data );
	}

	public function pAdd( Request $request, $id = null )
	{
		Validator::make( $request->all(), [
			'name'        => 'bail|required|max:255',
			'numbers'     => [
				'bail',
				'required',
				'numeric'
			],
			'draw_day'    => 'required',
			'description' => [
				'bail',
				'required'
			],
			'min_number'  => [
				'bail',
				'required',
				'numeric'
			],
			'max_number'  => [
				'bail',
				'required',
				'numeric'
			],
		] )->validate();

		if ( empty( $id ) ) {
			$item = new Game();
		} else {
			$item = Game::find( $id );
		}

		$path = ( ! empty( $item ) && ! empty( $item->image ) ) ? $item->image : null;
		if ( $request->hasFile( 'image' ) ) {
			$path = $request->file('image')->store(
				'games/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
			);
//			dd($path);
		}

		$drawDay = $request->draw_day;
		if ( is_array( $drawDay ) && count( $drawDay ) ) {
			$drawDay = implode( ',', $drawDay );
		}
		$data = [
			'name'               => $request->name,
			'image'              => $path,
			'numbers'            => $request->numbers,
			'min_number'         => $request->min_number,
			'max_number'         => $request->max_number,
			'has_special_number' => $request->has_special_number ? true : false,
			'draw_day'           => $drawDay,
			'draw_time'          => $request->draw_time,
			'description'        => $request->description,
			'ticket_price'       => $request->ticket_price,
			'id_game_api'        => $request->id_game_api
		];
		if ( $request->has_special_number ) {
			$data['min_special']     = $request->min_special;
			$data['max_special']     = $request->max_special;
			$data['special_numbers'] = $request->special_numbers;
		}
		$item->fill( $data );
		$item->save();
		if ( is_array( $request->prize_name ) ) {
			// remove old associates
			if ( ! empty( $id ) && $item->prizes()->count() ) {
				foreach ( $item->prizes()->get() as $prize ) {
					$prize->delete();
				}
			}
			// store the prizes
			foreach ( $request->prize_name as $key => $prizeName ) {
				$item->prizes()->save( new Prize( [
					'game_id'       => $item->id,
					'name'          => $prizeName,
					'match'         => $request->prize_match[ $key ],
					'match_special' => $request->prize_match_special[ $key ] ?? 0,
					'value'         => $request->prize_value[ $key ],
					'unit'          => $request->prize_unit[ $key ]
				] ) );
			}
		}

		if ( empty( $id ) ) {
			\Session::flash( 'msg_game', __( 'messages.add_success' ) );

			return redirect()->route( 'backend.game.index' );
		} else {
			\Session::flash( 'msg_game', __( 'messages.edit_success' ) );

			return redirect()->route( 'backend.game.vEdit', [ 'id' => $id ] );
		}
	}

	public function edit( $id )
	{
		$item      = Game::findOrFail( $id );
		$drawDays  = explode( ',', $item->draw_day );
		$prizes    = $item->prizes()->get();
		$jsonPrize = [];
		foreach ( $prizes as $prize ) {
			$jsonPrize[] = [
				'_id'           => $prize->id,
				'name'          => $prize->name,
				'match'         => $prize->match,
				'match_special' => $prize->match_special,
				'value'         => $prize->value,
				'unit'          => $prize->unit,
			];
		}
		$buttons   = [
			'saveButton' => true,
			'backButton' => route( 'backend.game.index' )
		];
		$jsonPrize = json_encode( $jsonPrize );

		return view( 'backend.game.add', compact( 'item', 'drawDays', 'jsonPrize', 'buttons' ) );
	}

	public function delete( $id )
	{
		$ids = explode( ",", $id );
		Game::destroy( $ids );
		\Session::flash( 'msg_game', __( 'messages.delete_success' ) );

		return redirect()->route( 'backend.game.index' );
	}

	public function drawResult( $id )
	{
		$game     = Game::findOrFail( $id );
		$drawDate = Carbon::now()->toDateString();
		// check if this game has drawn today
		$check = WinningNumber::where( [
			[ 'game_id', '=', $game->id ],
			[ 'draw_date', '=', $drawDate ]
		] )->first();

		if ( ! empty( $check ) ) {
			// alert user about this game
			return;
		}
		$arr    = range( $game->min_number, $game->max_number );
		$result = Number::getRandomSet( $arr, $game->numbers );
		$result = implode( ',', $result );

		$data = [
			'game_id'   => $game->id,
			'draw_date' => $drawDate,
			'numbers'   => $result,
		];
		if ( $game->has_special_number ) {
			$special                = mt_rand( $game->min_special, $game->max_special );
			$data['special_number'] = $special;
		}

		$winningNumber = new WinningNumber();
		$winningNumber->fill( $data );
		$winningNumber->save();
	}

	public function detail( $id )
	{
		$item     = Game::findOrFail( $id );
		$drawDays = explode( ',', $item->draw_day );
		$prizes   = $item->prizes()->get();

		return view( 'backend.game.detail', compact( 'item', 'drawDays', 'prizes' ) );
	}

	public function updateResultGame($id)
    {
        $game = Game::findOrFail($id);
        try {
        	// check time draw
        	$time = explode(':', $game->draw_time);
        	$start_time = Carbon::create(date('Y', time()), date('m', time()), date('d', time()), $time[0], $time[1]);
        	$end_time = $start_time->copy()->addMinutes(30);
            $weekdays = explode(',', $game->draw_day);
            if(in_array(date('w', time()), $weekdays)) {
            	if(Carbon::now()->between($start_time, $end_time)) {
            		if(WinningNumber::where( [
						[ 'game_id', '=', $game->id ],
						[ 'draw_date', '=', date('Y-m-d', time()) ]
					] )->first()) {
		                return response()->json([
				        	'success' => false, 
				        	'msg' => __('messages.error_update_result_game_exist')
				        ]);
		            }
	            } else {
	            	return response()->json([
			        	'success' => false, 
			        	'msg' => __('messages.update_result_game_timeout')
			        ]);
	            }
            } else {
            	return response()->json([
		        	'success' => false, 
		        	'msg' => __('messages.update_result_game_timeout')
		        ]);
            }

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
            return response()->json([
            	'success' => true,
            	'msg' => __('messages.update_success_result_game')
            ]);
        } catch(Exception $e) {
            \DB::rollBack();
            return response()->json([
            	'success' => false, 
            	'msg' => __('messages.error_system_update_result_game')
            ]);
        }
    }
}
