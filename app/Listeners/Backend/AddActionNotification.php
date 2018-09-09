<?php

namespace App\Listeners\Backend;

use App\Events\Backend\AddAction;
use App\Helpers\OneSignal;
use App\Http\Models\Backend\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Models\Backend\Group;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddActionNotification {
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
	 * @param  AddAction $event
	 *
	 * @return void
	 */
	public function handle( AddAction $event ) {
		$action = $event->action;
		$this->sendAddTaskNotification( $action );
	}

	public function sendAddTaskNotification( $action ) {
		$content = array(
			"en" => __( 'notification.action.add', [
				'user'        => Auth::user()->fullname,
				'action_name' => $action->name
			], 'en' ),
			'vi' => __( 'notification.action.add', [
				'user'        => Auth::user()->fullname,
				'action_name' => $action->name
			], 'vi' ),
		);
		if ( $action->for_all_group ) {
			$groups = Group::all();
		} else {
			$groups = $action->groups;
		}
		$ids = [];
		foreach ( $groups as $group ) {
			$ids = array_merge($ids, $group->users()->pluck('id')->all());
		}
		$ids = array_unique($ids);
		// tạo thông báo trong hệ thống
		// create system notification
		$data = [];
		foreach ( $ids as $id ) {
			$data[] = [
				'content' => 'notification.action.add',
				'replace' => json_encode([
					'user'        => Auth::user()->fullname,
					'action_name' => $action->name
				]),
				'user_id' => $id,
				'created_at' => Carbon::now()->toDateTimeString(),
				'created_by' => Auth::user()->id
			];
		}
		Notification::insert($data);

		$filters = [];
		foreach ( $ids as $index => $id ) {
			$filters[] = [
				'field'    => 'tag',
				'key'      => 'user_id',
				'relation' => '=',
				'value'    => $id
			];

			if ( $index < count( $ids ) - 1 ) {
				$filters[] = [
					'operator' => 'OR'
				];
			}
		}
		$url = route( 'backend.notification.index');

		if( count($ids) ) {
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
