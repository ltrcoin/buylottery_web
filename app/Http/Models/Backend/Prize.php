<?php

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model {
	protected $table = 'prizes';
	public $timestamps = true;

	protected $fillable = [ 'game_id', 'name', 'match', 'match_special', 'value', 'unit' ];

	public function game ()
	{
		return $this->belongsTo(Game::class);
	}
}
