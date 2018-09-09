<?php

namespace App\Listeners\Backend;

use App\Events\Backend\AddTask;
use App\Helpers\OneSignal;
use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\Notification;
use App\Http\Models\Backend\Organize;
use App\Http\Models\Backend\Task;
use App\Http\Models\Backend\User;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddTaskNotification {
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
	 * @param  AddTask $event
	 *
	 * @return void
	 */
	public function handle( AddTask $event ) {
		$task = $event->task;
		$this->sendAddTaskNotification( $task );
	}

	public function sendAddTaskNotification( $task ) {
		$content              = array(
			"en" => __( 'notification.task.add', [
				'name'       => $task->name,
				'task_owner' => $task->organization->name
			], 'en' ),
			'vi' => __( 'notification.task.add', [
				'name'       => $task->name,
				'task_owner' => $task->organization->name
			], 'vi' ),
		);
		$notificationReceiver = OneSignal::getTaskStatusChangedReceiver( $task );
		$type                 = $notificationReceiver['type'];
		$ids                  = $notificationReceiver['ids'];

		// create system notification
		$data = [];
		foreach ( $ids as $id ) {
			$data[] = [
				'content'    => 'notification.task.add',
				'replace'    => json_encode( [
					'name'       => $task->name,
					'task_owner' => $task->organization->name
				] ),
				'user_id'    => $id,
				'created_at' => Carbon::now()->toDateTimeString(),
				'created_by' => Auth::user()->id
			];
		}
		Notification::insert( $data );
		$filters = [];
		foreach ( $ids as $index => $id ) {
			if ( $type != 'user' ) {
				$filters[] = [
					'field'    => 'tag',
					'key'      => $type . '_' . $id,
					'relation' => 'exists'
				];
			} else {
				$filters[] = [
					'field'    => 'tag',
					'key'      => 'user_id',
					'relation' => '=',
					'value'    => $id
				];
			}

			if ( $index < count( $ids ) - 1 ) {
				$filters[] = [
					'operator' => 'OR'
				];
			}
		}
		$url = route( 'backend.notification.index' );

		if ( count( $ids ) ) {
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
