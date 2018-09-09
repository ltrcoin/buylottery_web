<?php

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class WinningNumber extends Model {
	protected $table = 'winning_numbers';
	public $timestamps;

	protected $fillable = [ 'game_id', 'draw_date', 'numbers', 'special_numbers' ];
}
