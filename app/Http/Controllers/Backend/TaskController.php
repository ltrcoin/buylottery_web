<?php

namespace App\Http\Controllers\Backend;

use App\Events\Backend\AddTask;
use App\Events\Backend\UpdateTask;
use App\Http\Models\Backend\Action;
use App\Http\Models\Backend\FormField;
use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\Organize;
use App\Http\Models\Backend\Task;
use App\Http\Models\Backend\User;
use App\Http\Controllers\Controller;
use App\Listeners\Backend\UpdateTaskNotification;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Excel;

class TaskController extends BaseController {


	// index of column in column list
	protected $defaultOrderBy = 0;
	protected $defaultOrderDir = 'desc';
	protected $model = Task::class;
	protected $module_name = 'task'; // tên dùng khi đặt tên route, ví dụ backend.task.index -> lấy tên `task`
	protected $messageName = 'msg_task'; // tên của flash message
	protected $toolbar = 'backend.task.toolbar';
	protected $initTableScript = 'backend.task.initTableScript';

	protected $buttons = [
		'createButton' => '/admin/task/add',
		'deleteButton' => '/admin/task/delete'
	];
	protected $listTitle = 'label.tasks.title';

	public function __construct( Container $app ) {
		parent::__construct( $app );
		$this->fieldList = [
			[
				'name'        => 'id',
				'title'       => '#',
				'filter_type' => '#',
				'width'       => '2%' // default width 2%
			],
			[
				'name'        => 'name',
				'title'       => 'label.tasks.name',
				'filter_type' => 'text',
				'width'       => '18%'
			],
			[
				'name'        => 'organization_id',
				'title'       => 'label.tasks.org_owner',
				'orderable'   => false,
				'filter_type' => 'select',
				'width'       => '15%',
				'relation'    => [
					'object'  => 'organization',
					'display' => 'name',
					'type'    => 1
				],
				'refer'       => [
					'source_table' => 'organize',
					'value_column' => 'id',
					'label_column' => 'name'
				]
			],
			[
				'name'        => 'actions',
				'title'       => 'label.actions.list_title',
				'orderable'   => false,
				'filter_type' => 'select',
				'width'       => '18%',
				'relation'    => [
					'object'  => 'actions',
					'display' => 'name',
					'search'  => 'id',
					'type'    => 'n'
				],
				'refer'       => [
					'source_table' => 'actions',
					'value_column' => 'id',
					'label_column' => 'name'
				]
			],
			[
				'name'        => 'receiver',
				'title'       => 'label.tasks.receiver',
				'orderable'   => false,
				'filter_type' => '#',
				'width'       => '15%',
//			'relation' => [
//				[
//					'object' => 'organizations',
//					'type' => 'n'
//				],
//				[
//					'object' => 'groups',
//					'type' => 'n'
//				],
//				[
//					'object' => 'users',
//					'type' => 'n'
//				]
//			],
//			'refer' => [
//				[
//					'source_table' => 'organize',
//					'value_column' => 'id',
//					'label_column' => 'name'
//				],
//				[
//					'source_table' => 'group',
//					'value_column' => 'id',
//					'label_column' => 'name'
//				],
//				[
//					'source_table' => 'users',
//					'value_column' => 'id',
//					'label_column' => 'fullname'
//				]
//			]
			],
			[
				'name'        => 'start_date',
				'title'       => 'label.tasks.start_date',
				'filter_type' => 'date-range',
				'width'       => '10%',
				'className'   => 'text-center',
			],
			[
				'name'        => 'end_date',
				'title'       => 'label.tasks.end_date',
				'filter_type' => 'date-range',
				'width'       => '10%',
				'className'   => 'text-center',
			],
			[
				'name'        => 'status',
				'title'       => 'label.tasks.status',
				'filter_type' => '#',
				'width'       => '10%',
//				'refer' => Task::$STATUS
			],
			[
				'name'        => '_',
				'title'       => '',
				'filter_type' => '#',
				'width'       => '2%', // default 2%
			]
		];
	}

	public function _createIndexData( $items ) {
		$data = [];
		foreach ( $items as $item ) {
			$row = [];
			foreach ( $this->fieldList as $field ) {
				if ( $field['title'] == 'label.tasks.receiver' ) {
					$type = $item->type;
					if ( empty( $item->assign_all ) ) {
						switch ( $type ) {
							case \App\Http\Models\Backend\Task::TYPE_ORG:
								$row[] = implode( ', ', $item->organizations->pluck( 'name' )->all() );
								break;
							case \App\Http\Models\Backend\Task::TYPE_GROUP:
								$row[] = implode( ', ', $item->groups->pluck( 'name' )->all() );
								break;
							case \App\Http\Models\Backend\Task::TYPE_USER:
								$row[] = implode( ', ', $item->users->pluck( 'fullname' )->all() );
								break;
						}
					} else {
						$row[] = __( 'label.all' ) . ' ' . __( 'label.tasks.' . \App\Http\Models\Backend\Task::$TYPE[ $item->type ] );
					}
				} elseif ( $field['title'] == 'label.tasks.status' ) {
					$row[] = __( 'label.tasks.' . Task::$STATUS[ $item->status ] );
				} else {
					if ( array_key_exists( 'relation', $field ) ) {
						if ( $field['relation']['type'] == 1 ) {
                            try {
                                $row[] = $item->{$field['relation']['object']}->{$field['relation']['display']};
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                                $row[] = '';
                            }
						} else {
							$row[] = implode( ', ', $item->{$field['relation']['object']}->pluck( $field['relation']['display'] )->all() );
						}

					} elseif($field['filter_type'] == 'date-range') {
						// display date data in localize format
						$row[] = Carbon::parse($item->{$field['name']})->format(__('label.date_format'));
					} else {
						$row[] = $item->{$field['name']};
					}
				}
			}
			$data[] = $row;
		}

		return $data;
	}

	public function add() {
		$data['status']  = Task::$STATUS;
		$data['type']    = Task::$TYPE;
		$data['buttons'] = [
			'saveButton' => true,
			'backButton' => route( 'backend.task.index' )
		];

		return view( 'backend.task.add', $data );
	}

	public function pAdd( Request $request, $id = null ) {
		Validator::make( $request->all(), [
			'name'            => 'bail|required|max:255',
			'organization_id' => [
				'bail',
				'required'
			],
			'type'            => [
				'bail',
				'required'
			],
			'description'     => [
				'bail',
				'required'
			],
			'status'          => [
				'bail',
				'required'
			],
			'start_date'      => [
				'bail',
				'required'
			],
			'end_date'        => [
				'bail',
				'required'
			],
			'actions'         => [
				'bail',
				'required'
			]
		] )->validate();
		if($request->has('form_field')) {
			foreach ($request->form_field as $k => $v){
				if($v['name'] == null ||  $v['type'] == null){
					\Session::flash('msg_task', __( 'flash.input_field' ));
					if (empty($id)) {
						return redirect()->route('backend.task.vAdd');
					} else {
						return redirect()->route('backend.task.vEdit',['id'=>$id]);
					}
				}
			}
		}
		if ( empty( $id ) ) {
			$item = new Task();
		} else {
			$item = Task::find( $id );
			$oldTask = clone $item;
		}
		$item->fill( $request->all() );
		if(!isset($request->assign_all)) {
			$item->assign_all = 0;
		}
		$item->save();
		$item->actions()->sync( $request->input( 'actions' ) );
		$receiver = ( $request->assign_all ) ? [] : $request->input( 'receiver' );
		switch ( $item->type ) {
			case Task::TYPE_ORG :
				$item->organizations()->sync( $receiver );
				break;
			case Task::TYPE_GROUP :
				$item->groups()->sync( $receiver );
				break;
			case Task::TYPE_USER :
				$item->users()->sync( $receiver );
				break;
		}

		// lưu các trường trong form dành cho tác vụ
		if($request->has('form_field')){
			if( ! empty( $id) ) {
				FormField::select('field_name','field_type')->where('task_id', $id)->delete();
			}
			foreach ($request->form_field as $k => $v){
				$form_field = new FormField();
				$form_field->field_name =  $v['name'];
				$form_field->field_type =  $v['type'];
				$form_field->task_id = $item->id;
				$form_field->save();
			}
		}
		if ( empty( $id ) ) {
			\Session::flash( 'msg_task', __( 'messages.add_success' ) );
			event(new AddTask($item));
		} else {
			\Session::flash( 'msg_task', __( 'messages.edit_success' ) );
			event(new UpdateTask($oldTask, $item));
		}


		return redirect()->route( 'backend.task.index' );
	}

	public function edit( $id ) {
		$item = Task::find( $id );
		if ( $item ) {
			$data['status'] = Task::$STATUS;
			$data['type']   = Task::$TYPE;

			$data['model']   = $item;

			$form_field = FormField::select('field_name','field_type')->where('task_id', $id)->get();
			$data['formField'] = $form_field;
			if (App::isLocale('en')) {
				$data['listType'] = FormField::$fieldTypeEn;
			}
			if (App::isLocale('vi')) {
				$data['listType'] = FormField::$fieldTypeVi;
			}

			$data['buttons'] = [
				'saveButton' => true,
				'backButton' => route( 'backend.task.index' )
			];

			return view( 'backend.task.edit', $data );
		} else {
			return redirect()->route( 'backend.site.error', [ 'errorCode' => 404, 'msg' => "Not found request!" ] );
		}
	}

	public function updateStatus( Request $request ) {
		$task = Task::find( $request->pk );
		if ( $task ) {
			$oldTask = clone $task;
			$task->status = $request->value;
			$task->save();
			event(new UpdateTask($oldTask, $task));
		} else {
			return response()->json( [
				'status' => 'false',
				'msg'    => __( 'label.task.not_found' )
			] );
		}

		return response()->json( [
			'status' => 'success',
			'msg'    => 'success updated'
		] );
	}

	public function dataSelect( Request $request ) {
		$term  = $request->term;
		$items = [];
		if ( $term ) {
			switch ( $request->type ) {
				case Task::TYPE_ORG :
					$items = Organize::where( 'name', 'like', '%' . strtolower( $term ) . '%' )->select( [
						'id',
						'name as text'
					] )->get();
					break;
				case Task::TYPE_GROUP :
					$items = Group::where( 'name', 'like', '%' . strtolower( $term ) . '%' )->select( [
						'id',
						'name as text'
					] )->get();
					break;
				case Task::TYPE_USER :
					$items = User::where( 'fullname', 'like', '%' . strtolower( $term ) . '%' )->select( [
						'id',
						'fullname as text'
					] )->get();
					break;
				case 'action':
					$items = Action::where( 'name', 'like', '%' . strtolower( $term ) . '%' )->select( [
						'id',
						'name as text'
					] )->get();
					break;
				default:
					$items = [];
					break;
			}
		}

		return response()->json( [
			'items' => $items
		] );
	}

	public function checkActionPermission( Request $request ) {
		$ids      = $request->ids;
		$checkIn  = true;
		$checkOut = true;

		if ( ! empty( $ids ) ) {
			$actions = Action::whereIn( 'id', $ids )->get();

			foreach ( $actions as $action ) {
				if ( ! $action->can_checkin ) {
					$checkIn = false;
				}
				if ( ! $action->can_checkout ) {
					$checkOut = false;
				}
			}
		}

		return response()->json( compact( 'checkIn', 'checkOut' ) );
	}

	public function delete( $id ) {
		$ids = explode( ",", $id );
		Task::destroy( $ids );
		\Session::flash( 'msg_task', __( 'messages.delete_success' ) );

		return redirect()->route( 'backend.task.index' );
	}

	public function detail( $id ) {
		$item = Task::find( $id );
		$form_field = FormField::select('field_name','field_type')->where('task_id', $id)->get();
		if (App::isLocale('en')) {
			$listType = FormField::$fieldTypeEn;
		}
		if (App::isLocale('vi')) {
			$listType = FormField::$fieldTypeVi;
		}
		foreach ( $form_field as $index => $field ) {
			$form_field[$index]['field_type'] = $listType[$form_field[$index]['field_type']];
		}


		return view( 'backend.task.detail', [ 'item' => $item, 'form_field' => $form_field ] );
	}

	public function statusSource( $id ) {
		$actionIds = Task::find($id)->actions->pluck('id')->all();

		$checkIn  = true;
		$checkOut = true;

		if ( ! empty( $actionIds ) ) {
			$actions = Action::whereIn( 'id', $actionIds )->get();

			foreach ( $actions as $action ) {
				if ( ! $action->can_checkin ) {
					$checkIn = false;
				}
				if ( ! $action->can_checkout ) {
					$checkOut = false;
				}
			}
		}

		$status = Task::$STATUS;
		if(!$checkIn) {
			unset($status[Task::STATUS_CHECK_IN]);
		}
		if(!$checkOut) {
			unset($status[Task::STATUS_CHECK_OUT]);
		}
		$options = [];
		foreach ( $status as $key => $val ) {
			$options[] = [
				'value' => $key,
				'text' => __('label.tasks.' . $val)
			];
		}
		return $options;
	}

	public function downloadForm( $id )
	{
		$form_field = FormField::select('field_name','field_type')->where('task_id', $id)->get()->toArray();

		if (App::isLocale('en')) {
			$listType = FormField::$fieldTypeEn;
		}
		if (App::isLocale('vi')) {
			$listType = FormField::$fieldTypeVi;
		}
		foreach ( $form_field as $index => $field ) {
			$form_field[$index]['field_type'] = $listType[$form_field[$index]['field_type']];
		}

		Excel::create('report_form_task_' . $id, function($excel) use($form_field){
			$excel->sheet('Sheet 1', function($sheet) use($form_field){
				$sheet->fromArray($form_field);
			});
		})->export('xlsx');
	}
}
