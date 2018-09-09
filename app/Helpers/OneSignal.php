<?php
/**
 * Created by: chungvh
 * Date: 03/06/2018
 * Time: 3:40 SA
 */

namespace App\Helpers;


use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\Organize;
use App\Http\Models\Backend\Task;
use App\Http\Models\Backend\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Log;

class OneSignal {
	/**
	 * @param array $content
	 * @param array $filters
	 * @param string $url
	 *
	 * @return mixed
	 */
	public static function sendNotification( array $content, array $filters = [], string $url = '' ) {
		$fields = array(
			'app_id'            => env( 'ONESIGNAL_APP_ID' ),
			'included_segments' => array(
				'All'
			),
			'contents'          => $content,
		);

		if ( ! empty( $url ) ) {
			$fields['url'] = $url;
		}
		if ( ! empty( $filters ) ) {
			$fields['filters'] = $filters;
		}

		$fields = json_encode( $fields );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications" );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json; charset=utf-8',
			'Authorization: Basic ' . env( 'ONESIGNAL_API_KEY' )
		) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return $response;
	}

	/**
	 * @param Authenticatable|null $user
	 */
	public static function getTags( Authenticatable $user = null ) {
		$tags = [
			'user_id'   => $user->id,
			'real_name' => $user->fullName,
			'locale'    => ( empty( \Session::get( 'locale' ) ) ? 'vi' : \Session::get( 'locale' ) )
		];
		// get group
		$groups = User::find( $user->id )->groups()->pluck( 'id' )->all();
		foreach ( $groups as $group ) {
			$tags[ 'group_' . $group ] = 'on';
		}

		return $tags;
	}

	/**
	 * Trả về kiểu của đối tượng nhận (user) và danh sách các id nhận (mảng user id)
	 *
	 * @param $task
	 *
	 * @return array
	 */
	public static function getTaskStatusChangedReceiver( $task ) {
		$ids = [];
		switch ( $task->type ) {
			case Task::TYPE_ORG :
				$type = 'user';
				if ( $task->assign_all ) {
					$ids  = [];
					$orgs = Organize::all();
					foreach ( $orgs as $org ) {
						$users = $org->users();
						$ids   = array_merge( $ids, $users );
					}
				} else {
					$ids  = [];
					$orgs = $task->organizations;
					foreach ( $orgs as $org ) {
						$users = $org->users();
						$ids   = array_merge( $ids, $users );
					}
				}
				$ids = array_unique( $ids );
				break;
			case Task::TYPE_GROUP :
				$type = 'user';
				if ( $task->assign_all ) {
					$groups = Group::all();
				} else {
					$groups = $task->groups;
				}
				$ids = [];
				foreach ( $groups as $group ) {
					$ids = array_merge( $ids, $group->users()->pluck( 'id' )->all() );
				}
				$ids = array_unique( $ids );
				break;
			case Task::TYPE_USER :
				$type = 'user';
				if ( $task->assign_all ) {
					$ids = User::all()->pluck( 'id' )->all();
				} else {
					$ids = $task->users->pluck( 'id' )->all();
				}
				break;
		}

		return compact( 'type', 'ids' );
	}

	/**
	 * @param string $type group hoặc user
	 * @param array $ids danh sách các group id hoặc user id
	 *
	 * @return array
	 */
	public static function getFilters( $type, $ids ) {
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

		return $filters;
	}

	public static function getActionReceiverChange( $old, $new ) {
		if ( $old->for_all_group ) {
			$groups = Group::all();
		} else {
			$groups = $old->groups;
		}
		$ids = [];
		foreach ( $groups as $group ) {
			$ids = array_merge( $ids, $group->users()->pluck( 'id' )->all() );
		}
		$oldIds = array_unique( $ids );

		if ( $new->for_all_group ) {
			$groups = Group::all();
		} else {
			$groups = $new->groups;
		}
		$ids = [];
		foreach ( $groups as $group ) {
			$ids = array_merge( $ids, $group->users()->pluck( 'id' )->all() );
		}
		$newIds = array_unique( $ids );

		return [
			'removed' => array_diff( $oldIds, $newIds ),
			'added'   => array_diff( $newIds, $oldIds )
		];
	}
}