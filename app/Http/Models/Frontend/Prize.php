<?php

namespace App\Http\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
	protected $table = 'prizes';

	public function game ()
	{
		return $this->belongsTo(Game::class);
	}
}
