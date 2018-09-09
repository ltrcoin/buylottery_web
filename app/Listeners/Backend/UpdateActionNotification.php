<?php

namespace App\Listeners\Backend;

use App\Events\Backend\UpdateAction;
use App\Helpers\OneSignal;
use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\Notification;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateActionNotification {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  UpdateAction $event
	 *
	 * @return void
	 */
	public function handle( UpdateAction $event ) {
		$old = $event->oldAction;
		$new = $event->newAction;

		$diffReceiver = OneSignal::getActionReceiverChange( $old, $new );

		// tạo thông báo cho các user thuộc group bị xóa đi
		if ( count( $diffReceiver['removed'] ) ) {
			$content = array(
				"en" => __( 'notification.action.cancel', [
					'user'        => Auth::user()->fullname,
					'action_name' => $new->name
				], 'en' ),
				'vi' => __( 'notification.action.cancel', [
					'user'        => Auth::user()->fullname,
					'action_name' => $new->name
				], 'vi' ),
			);

			// tạo thông báo trong hệ thống
			// create system notification
			$data = [];
			foreach ( $diffReceiver['removed'] as $id ) {
				$data[] = [
					'content'    => 'notification.action.cancel',
					'replace'    => json_encode( [
						'user'        => Auth::user()->fullname,
						'action_name' => $new->name
					] ),
					'user_id'    => $id,
					'created_at' => Carbon::now()->toDateTimeString(),
					'created_by' => Auth::user()->id
				];
			}
			Notification::insert( $data );

			$filters = [];
			foreach ( $diffReceiver['removed'] as $index => $id ) {
				$filters[] = [
					'field'    => 'tag',
					'key'      => 'user_id',
					'relation' => '=',
					'value'    => $id
				];

				if ( $index < count( $diffReceiver['removed'] ) - 1 ) {
					$filters[] = [
						'operator' => 'OR'
					];
				}
			}
			$url = route( 'backend.notification.index' );

			foreach ( $content as $locale => $content_locale ) {
				$localeFilters   = $filters;
				$localeFilters[] = [
					'field'    => 'tag',
					'key'      => 'locale',
					'relation' => '=',
					'value'    => $locale
				];
				$content_locale  = [
					'en' => $content_locale
				];
				OneSignal::sendNotification( $content_locale, $localeFilters, $url );
			}
		}

		// tạo thông báo cho các user thuộc group mới thêm vào
		if ( count( $diffReceiver['added'] ) ) {
			$content = array(
				"en" => __( 'notification.action.add', [
					'user'        => Auth::user()->fullname,
					'action_name' => $new->name
				], 'en' ),
				'vi' => __( 'notification.action.add', [
					'user'        => Auth::user()->fullname,
					'action_name' => $new->name
				], 'vi' ),
			);

			// tạo thông báo trong hệ thống
			// create system notification
			$data = [];
			foreach ( $diffReceiver['added'] as $id ) {
				$data[] = [
					'content'    => 'notification.action.add',
					'replace'    => json_encode( [
						'user'        => Auth::user()->fullname,
						'action_name' => $new->name
					] ),
					'user_id'    => $id,
					'created_at' => Carbon::now()->toDateTimeString(),
					'created_by' => Auth::user()->id
				];
			}
			Notification::insert( $data );

			$filters = [];
			foreach ( $diffReceiver['added'] as $index => $id ) {
				$filters[] = [
					'field'    => 'tag',
					'key'      => 'user_id',
					'relation' => '=',
					'value'    => $id
				];

				if ( $index < count( $diffReceiver['added'] ) - 1 ) {
					$filters[] = [
						'operator' => 'OR'
					];
				}
			}
			$url = route( 'backend.notification.index' );

			foreach ( $content as $locale => $content_locale ) {
				$localeFilters   = $filters;
				$localeFilters[] = [
					'field'    => 'tag',
					'key'      => 'locale',
					'relation' => '=',
					'value'    => $locale
				];
				$content_locale  = [
					'en' => $content_locale
				];
				OneSignal::sendNotification( $content_locale, $localeFilters, $url );
			}
		}
	}
}
