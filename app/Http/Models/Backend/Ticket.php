<?php

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $table = 'tickets';
	public $timestamps;

	const WARNING = 0;
	const COMPLETED = 1;

	protected $fillable = [ 'game_id', 'user_id', 'numbers', 'special_numbers' ];

	public function game()
	{
		return $this->belongsTo(Game::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class, 'user_id', 'id');
	}
}
