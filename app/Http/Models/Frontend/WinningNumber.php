<?php

namespace App\Http\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class WinningNumber extends Model {
	protected $table = 'winning_numbers';
	public $timestamps;
	const PAGE_SIZE = 5;

	protected $fillable = [ 'game_id', 'draw_date', 'numbers', 'special_numbers' ];

	public function game() {
		return $this->belongsTo(Game::class, 'game_id', 'id');
	}
}
