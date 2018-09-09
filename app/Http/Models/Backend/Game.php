<?php

namespace App\Http\Models\Backend;

use App\Http\Models\Backend\Traits\AliasGenerate;
use App\Http\Models\Backend\Traits\SaveImage;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
	use SoftDeletes;
	use AliasGenerate;

	protected $table = 'games';
	public $timestamps = true;

	protected $dates = [ 'deleted_at' ];
	protected $fillable = [
		'name',
		'alias',
		'image',
		'numbers',
		'min_number',
		'max_number',
		'has_special_number',
		'special_numbers',
		'min_special',
		'max_special',
		'draw_time',
		'draw_day',
		'description',
		'ticket_price',
		'id_game_api'
	];
	const MEGAMILLION_ID = 'us_mega_millions';
	const EUROJACKPOT_ID = 'eurojackpot';

	public static function boot()
	{
		parent::boot();
		self::creating( function ( $item ) {
			$item->aliasOnCreate();
		} );
		self::updating( function ( $item ) {
			$item->aliasOnUpdate();
		} );
	}

	public function findByAlias( $alias )
	{
		return $this->where( 'alias', $alias )->firstOrFail();
	}

	public function prizes()
	{
		return $this->hasMany( Prize::class, 'game_id' );
	}
}
