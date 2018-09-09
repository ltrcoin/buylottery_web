<?php

namespace App\Listeners\Backend;

use App\Events\Backend\UpdateTask;
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

class UpdateTaskNotification {

	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Handle the event.
	 *
	 * @param  UpdateTask $event
	 *
	 * @return void
	 */
	public function handle( UpdateTask $event ) {
		$oldTask = $event->oldTask;
		$newTask = $event->newTask;

		if ( $newTask->status != $oldTask->status ) {
			$this->sendStatusChangedMessage( $oldTask, $newTask );
		}

		$this->sendReceiverChangedMessage( $oldTask, $newTask );
	}

	public function sendStatusChangedMessage( $oldTask, $newTask ) {
		$content              = array(
			"en" => __( 'notification.task.status_change', [
				'name' => $newTask->name,
				'old'  => __( 'label.tasks.' . Task::$STATUS[ $oldTask->status ] ),
				'new'  => __( 'label.tasks.' . Task::$STATUS[ $newTask->status ] )
			], 'en' ),
			'vi' => __( 'notification.task.status_change', [
				'name' => $newTask->name,
				'old'  => __( 'label.tasks.' . Task::$STATUS[ $oldTask->status ] ),
				'new'  => __( 'label.tasks.' . Task::$STATUS[ $newTask->status ] )
			], 'vi' ),
		);
		$notificationReceiver = OneSignal::getTaskStatusChangedReceiver( $newTask );
		$type                 = $notificationReceiver['type'];
		$ids                  = $notificationReceiver['ids'];
		$filters              = OneSignal::getFilters( $type, $ids );

		// create system notification
		$data = [];
		foreach ( $ids as $id ) {
			$data[] = [
				'content'    => 'notification.task.status_change',
				'replace'    => json_encode( [
					'name' => $newTask->name,
					'old'  => __( 'label.tasks.' . Task::$STATUS[ $oldTask->status ] ),
					'new'  => __( 'label.tasks.' . Task::$STATUS[ $newTask->status ] )
				] ),
				'user_id'    => $id,
				'created_at' => Carbon::now()->toDateTimeString(),
				'created_by' => Auth::user()->id
			];
		}
		Notification::insert( $data );
		$url = route( 'backend.notification.index' );

		// phải xác định danh sách user mới gửi nếu không sẽ bị gửi sai thành gửi cho toàn bộ người dùng
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

	public function sendReceiverChangedMessage( $oldTask, $newTask ) {
		$oldTargets = OneSignal::getTaskStatusChangedReceiver( $oldTask );
		$newTargets = OneSignal::getTaskStatusChangedReceiver( $newTask );

		if ( $oldTargets['type'] != $newTargets['type'] ) {
			// thông báo tất cả đối tượng cũ là tác vụ không giao cho họ nữa
			$content = array(
				"en" => __( 'notification.task.cancel', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'en' ),
				'vi' => __( 'notification.task.cancel', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'vi' ),
			);
			// create system notification
			$data = [];
			foreach ( $oldTargets['ids'] as $id ) {
				$data[] = [
					'content'    => 'notification.task.cancel',
					'replace'    => json_encode( [
						'name'       => $newTask->name,
						'task_owner' => $newTask->organization->name
					] ),
					'user_id'    => $id,
					'created_at' => Carbon::now()->toDateTimeString(),
					'created_by' => Auth::user()->id
				];
			}
			Notification::insert( $data );


			$filters = OneSignal::getFilters( $oldTargets['type'], $oldTargets['ids'] );
			$url     = route( 'backend.notification.index' );

			if ( count( $oldTargets['ids'] ) ) {
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
			// thông báo tất cả đối tượng mới là tác vụ giao cho họ
			$content = array(
				"en" => __( 'notification.task.add', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'en' ),
				'vi' => __( 'notification.task.add', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'vi' ),
			);
			// create system notification
			$data = [];
			foreach ( $newTargets['ids'] as $id ) {
				$data[] = [
					'content'    => 'notification.task.add',
					'replace'    => json_encode( [
						'name'       => $newTask->name,
						'task_owner' => $newTask->organization->name
					] ),
					'user_id'    => $id,
					'created_at' => Carbon::now()->toDateTimeString(),
					'created_by' => Auth::user()->id
				];
			}
			Notification::insert( $data );

			$filters = OneSignal::getFilters( $newTargets['type'], $newTargets['ids'] );
			$url     = route( 'backend.notification.index' );

			if ( count( $newTargets['ids'] ) ) {
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
		} else {
			// cùng kiểu group hay user thì tìm ra danh sách id bị xóa đi (có ở old nhưng không có ở new) để báo tác vụ hủy
			$remove  = array_diff( $oldTargets['ids'], $newTargets['ids'] );
			$content = array(
				"en" => __( 'notification.task.cancel', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'en' ),
				'vi' => __( 'notification.task.cancel', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'vi' ),
			);

			// create system notification
			$data = [];
			foreach ( $remove as $id ) {
				$data[] = [
					'content'    => 'notification.task.cancel',
					'replace'    => json_encode( [
						'name'       => $newTask->name,
						'task_owner' => $newTask->organization->name
					] ),
					'user_id'    => $id,
					'created_at' => Carbon::now()->toDateTimeString(),
					'created_by' => Auth::user()->id
				];
			}
			Notification::insert( $data );

			$filters = OneSignal::getFilters( $newTargets['type'], $remove );
			$url     = route( 'backend.notification.index' );

			if ( count( $remove ) ) {
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
			// tìm ra danh sách id mới thêm (có ở new không có ở old) để báo họ nhận tác vụ
			$new     = array_diff( $newTargets['ids'], $oldTargets['ids'] );
			$content = array(
				"en" => __( 'notification.task.add', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'en' ),
				'vi' => __( 'notification.task.add', [
					'name'       => $newTask->name,
					'task_owner' => $newTask->organization->name
				], 'vi' ),
			);

			// create system notification
			$data = [];
			foreach ( $new as $id ) {
				$data[] = [
					'content'    => 'notification.task.add',
					'replace'    => json_encode( [
						'name'       => $newTask->name,
						'task_owner' => $newTask->organization->name
					] ),
					'user_id'    => $id,
					'created_at' => Carbon::now()->toDateTimeString(),
					'created_by' => Auth::user()->id
				];
			}
			Notification::insert( $data );

			$filters = OneSignal::getFilters( $newTargets['type'], $new );
			$url     = route( 'backend.notification.index' );

			if ( count( $new ) ) {
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
}
