<?php
/**
 * Created by: chungvh
 * Date: 04/08/2018
 * Time: 11:30 CH
 */

namespace App\Helpers;


class Number
{
	public static function getRandomSet( $arr, $nums, $set = null )
	{
		$set = $set ?? [];
		if ( $nums == count( $set ) ) {
			asort( $set );

			return $set;
		}

		$randomIndex = mt_rand( 0, count( $arr ) - 1 );
		$set[]       = $arr[ $randomIndex ];
		unset( $arr[ $randomIndex ] );

		return self::getRandomSet( array_values( $arr ), $nums, $set );
	}

	public static function checkExistedTicket( $existedTickets, $ticket )
	{
		$normal  = $ticket['normal'];
		$special = empty( $ticket['special'] ) ? null : $ticket['special'];
		foreach ( $existedTickets as $existed_ticket ) {
			$existedSpecial = empty( $existed_ticket['special'] ) ? null : $existed_ticket['special'];
			if ( $normal === $existed_ticket['normal'] && $special === $existedSpecial ) {
				return true;
			}
		}

		return false;
	}
}