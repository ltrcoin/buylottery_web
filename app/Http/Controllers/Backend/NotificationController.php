<?php

namespace App\Http\Controllers\Backend;

use App\Http\Models\Backend\Notification;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends BaseController {
	// index of column in column list
	protected $defaultOrderBy = 0;
	protected $defaultOrderDir = 'desc';
	protected $model = Notification::class;
	protected $module_name = 'notification'; // tên dùng khi đặt tên route, ví dụ backend.task.index -> lấy tên `task`
	protected $messageName = 'msg_notification'; // tên của flash message
	protected $listTitle = 'label.notification.list_title';
	protected $customScript = [
		'backend.notification.script'
	];
	protected $initTableScript = 'backend.notification.initTableScript';
	protected $toolbar = 'backend.notification.toolbar';

	public function __construct( Container $app ) {
		parent::__construct( $app );
		$this->buttons   = [
			'deleteButton'   => '/admin/notification/delete',
			'customControls' => [
				'<button style="margin-right: 10px" type="button" class="btn btn-primary mark-as-read pull-right"><i class="fa fa-check"></i> ' . __( 'label.notification.mark_as_read', [], \Session::get('locale') ) . '</button>
            <input type="hidden" id="markReadUrl" value="/admin/notification/markAsRead">'
			]
		];
		$this->fieldList = [
			[
				'name'        => 'id',
				'title'       => '#',
				'filter_type' => '#',
				'width'       => '2%'
			],
			[
				'name'        => 'content',
				'title'       => 'label.notification.content',
				'filter_type' => '#',
				'orderable'   => false,
			],
			[
				'name'        => 'created_at',
				'title'       => 'label.notification.created_at',
				'filter_type' => 'date-range',
				'className'   => 'text-center',
				'width'       => '15%'
			],
			[
				'name'        => '_',
				'title'       => '',
				'filter_type' => '#',
				'width'       => '8%'
			]
		];
	}

	public function getListItems() {
		if ( empty( $this->searchColumn ) && empty( $this->searchValue ) ) {
			$items = $this->model->where('user_id', Auth::user()->id);
			$items = $items->orderBy( $this->orderBy, $this->orderDirection )
			               ->skip( $this->start )
			               ->take( $this->length )
			               ->get();

			$recordsFiltered = $this->model->count();
			$recordsTotal    = $recordsFiltered;
		} else {
			$items = $this->continueQuery( null, 0, $this->searchColumn[0] );

			if ( count( $this->searchColumn ) > 1 ) {
				foreach ( $this->searchColumn as $s_index => $s_column ) {
					if ( $s_index > 0 ) {
						$items = $this->continueQuery( $items, $s_index, $s_column );
					}
				}
			}

			$items = $items->where('user_id', Auth::user()->id);

			$recordsFiltered = $items->count();
			$recordsTotal    = $this->model->count();

			$items = $items->orderBy( $this->orderBy, $this->orderDirection )
			               ->skip( $this->start )
			               ->take( $this->length )
			               ->get();

		}

		$data = $this->_createIndexData( $items );

		return [
			'draw'            => $this->draw,
			'data'            => $data,
			'recordsFiltered' => $recordsFiltered,
			'recordsTotal'    => $recordsTotal,
		];
	}

	public function _createIndexData( $items ) {
		$data = [];
		foreach ( $items as $item ) {
			$row = [];
			foreach ( $this->fieldList as $field ) {
				$locale = empty(\Session::get('locale')) ? 'vi' : \Session::get('locale');
				if ( array_key_exists( 'relation', $field ) ) {
					if ( $field['relation']['type'] == 1 ) {
						$row[] = $item->{$field['relation']['object']}->{$field['relation']['display']};
					} else {
						$row[] = implode( ', ', $item->{$field['relation']['object']}->pluck( $field['relation']['display'] )->all() );
					}

				} else {
					if ( $field['name'] == '_' ) {
						$row[] = 'x';
					} elseif ( $field['filter_type'] == 'date-range' ) {
						// display date data in localize format
//						$row[] = \Carbon\Carbon::parse($item->{$field['name']})->diffForHumans();
						$row[] = \Carbon\Carbon::parse($item->created_at)->format(__('label.datetime_format', [], $locale));
					} elseif ( $field['name'] == 'content' ) {
						$replace = empty( json_decode( $item->replace, true ) ) ? [] : json_decode( $item->replace, true );
						$row[]   = __( $item->content, $replace, $locale );
					} else {
						$row[] = $item->{$field['name']};
					}
				}
			}

			$data[] = $row;
		}

		return $data;
	}

	public function detail( $id ) {
		$item = Notification::findOrFail($id);
		if(!$item->mark_as_read) {
			$item->mark_as_read = 1;
			$item->save();
		}
		return view('backend.notification.detail', ['item' => $item]);
	}

	public function markAsRead ($id) {
		$ids = explode( ',', $id );
		Notification::whereIn('id', $ids)->update(['mark_as_read' => 1]);
		return redirect()->route( 'backend.notification.index' );
	}

	public function delete( $id ) {
		$ids = explode( ",", $id );
		Notification::destroy( $ids );
		\Session::flash( 'msg_notification', __( 'messages.delete_success' ) );

		return redirect()->route( 'backend.notification.index' );
	}
}
