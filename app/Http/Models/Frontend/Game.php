<?php

namespace App\Http\Models\Frontend;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
	use SoftDeletes;
	protected $table = 'games';

	public function findByAlias( $alias )
	{
		return $this->where( 'alias', $alias )->firstOrFail();
	}

	public function prizes()
	{
		return $this->hasMany(Prize::class, 'game_id');
	}

	public function getNextDraw()
	{
		$currentWeekDay = date('w');
		$drawDay = explode(',', $this->draw_day);
		$add = 0;
		foreach ( $drawDay as $key => $day ) {
			if($day >= $currentWeekDay) {
				$add = $day - $currentWeekDay;
				break;
			}
			if($key == count($drawDay)) {
				$add = 7 - ($currentWeekDay - $drawDay[0]);
			}
		}
		$currentDate = Carbon::now();
		$drawTime = explode(':', $this->draw_time);
		$drawDate = $currentDate->addDay($add)->setTime(
			$drawTime[0],
			$drawTime[1],
			$drawTime[2]
		);
		if($drawDate->isPast()) {
			$add = 7 - ($currentWeekDay - $drawDay[0]);
			$drawDate = $currentDate->addDay($add)->setTime(
				$drawTime[0],
				$drawTime[1],
				$drawTime[2]
			);
		} else {
			$drawDate = $drawDate->toDateTimeString();
		}
		return $drawDate;
	}
}
