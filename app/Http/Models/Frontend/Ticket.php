<?php

namespace App\Http\Models\Frontend;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	const WARNING = 0;
	const COMPLETED = 1;
	const PAGE_SIZE = 10;

    public function game()
    {
    	return $this->belongsTo(Game::class);
    }
}
