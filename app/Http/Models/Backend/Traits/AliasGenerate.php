<?php

namespace App\Http\Models\Backend\Traits;

use Cocur\Slugify\Slugify;

trait AliasGenerate
{
	public function aliasOnCreate()
	{
		$slug = new Slugify();

		$alias       = $slug->slugify( $this->name );
		$count       = self::withTrashed()->whereRaw( "alias RLIKE '^{$alias}(-[0-9]+)?$'" )->count();
		$this->alias = $count ? "{$alias}-{$count}" : $alias;
	}

	public function aliasOnUpdate()
	{
		$slug = new Slugify();

		$alias = $slug->slugify( $this->name );
		if ( ! preg_match( "/^{$alias}(-[0-9]+)?$/", $this->alias ) ) {
			$count = self::withTrashed()->whereRaw( "alias RLIKE '^{$alias}(-[0-9]+)?$'" )->count();

			$this->alias = $count ? "{$alias}-{$count}" : $alias;
		}
	}
}