<?php

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
	protected $table = 'winners';
	public $timestamps = true;

	const WARNING = 0;
	const COMPLETED = 1;

	public function customer() {
		return $this->belongsTo(Customer::class, 'user_id', 'id')
	}

	public function game() {
		return $this->belongsTo(Game::class, 'game_id', 'id')
	}

	public function ticket() {
		return $this->belongsTo(Ticket::class, 'ticket_id', 'id')
	}

	public function prize()
	{
		return $this->belongsTo( Prize::class, 'prize_id', 'id');
	}

	public function winningnumber() {
		return $this->belongsTo(WinningNumber::class, 'winning_number_id', 'id');
	}
}
