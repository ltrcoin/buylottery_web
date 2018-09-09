<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller {
	/**
	 * @var array
	 * danh sách các cột sẽ hiển thị ra bảng
	 */
	protected $fieldList = [];
	/**
	 * @var string
	 * namespace đầy đủ của Model chính dùng cho danh sách
	 * Ví dụ: 'App\Http\Backend\Models\Task' hoặc Task::class
	 */
	protected $model;
	protected $module_name; // tên dùng khi đặt tên route, ví dụ backend.task.index -> lấy tên `task`
	/**
	 * @var string
	 * đường dẫn tới file
	 */
	protected $initTableScript = 'backend.component.list.script.initTableScript';
	/**
	 * @var array string[]
	 * danh sách các javascript muốn dùng thêm trong trang list (viết script này vào template blade)
	 * dùng khi muốn sử dụng các biến php trong script
	 * giá trị các phần tử là đường dãn tới file blade ví dụ 'backend.task.script.abc'
	 *
	 */
	protected $customScript = [];
	/**
	 * @var string
	 * mặc định dùng view cơ bản này, có thể viết đè khi muốn có các cột dữ liệu hiển thị đặc biệt
	 */
	protected $listView = 'backend.component.list.list';
	/**
	 * @var string đường dẫn tới file view của thanh điều hướng (ví dụ: 'backend.task.toolbar')
	 */
	protected $toolbar;
	/**
	 * @var string
	 * tên của flash session dùng trên trang
	 */
	protected $messageName;
	/**
	 * @var array
	 * các nút hỗ trợ:
	 * backButton: đường dẫn quay trở lại trang trước (thường là trang index)
	 * createButton: đường dẫn tới trang thêm mới
	 * saveButton: giá trị true -> hiển thị nút Lưu/Save
	 * deleteButton: đường dẫn tới link xóa bản ghi
	 * customControls: mảng các nút ngoài danh sách trên, giá trị các phần tử là mã HTML của nút
	 */
	protected $buttons = []; // danh sách các nút sử dụng trên trang

	protected $listTitle = '';

	/**
	 * Nhóm các thuộc tính sử dụng cho dataTables
	 */
	protected $columns;
	protected $draw;
	protected $start;
	protected $length;
	protected $defaultOrderBy;
	protected $defaultOrderDir = 'asc';
	protected $orderBy;
	protected $orderDirection;
	protected $searchValue = [];
	protected $searchColumn = [];


	public function __construct( Container $app ) {
		$this->app = $app;
		$this->makeModel();
	}

	public function makeModel() {
		$model = $this->app->make( $this->model );

		if ( ! $model instanceof Model ) {
			throw new \Exception( "Class {$this->model} must be an instance of Illuminate\\Database\\Eloquent\\Model" );
		}

		return $this->model = $model;
	}

	public function index() {
		return view( $this->listView, [
			'fields'          => $this->fieldList,
			'defaultOrderBy'  => $this->defaultOrderBy,
			'defaultOrderDir' => $this->defaultOrderDir,
			'toolbar'         => $this->toolbar,
			'module_name'     => $this->module_name,
			'buttons'         => $this->buttons,
			'initTableScript' => $this->initTableScript,
			'customScript'    => $this->customScript,
			'messageName'     => $this->messageName,
			'unorderable'     => $this->_getUnorderableColumn(),
			'listTitle'       => $this->listTitle,
			'columnClasses'   => $this->_getColumnClass()
		] );
	}

	// lấy danh sách các cột không cho phép sắp xếp
	public function _getUnorderableColumn() {
		$columns = [];
		foreach ( $this->fieldList as $index => $item ) {
			if ( isset( $item['orderable'] ) && ! $item['orderable'] ) {
				$columns[] = $index;
			}
		}

		return $columns;
	}

	public function _getColumnClass() {
		$classes = [];
		foreach ( $this->fieldList as $index => $item ) {
			if ( isset( $item['className'] ) && ! empty($item['className']) ) {
				$classes[] = [
					'className' => $item['className'],
					'targets' => $index
				];
			}
		}
		return $classes;
	}

	public function _indexAjaxData( Request $request ) {
		$this->columns = $request->input( 'columns' );
		$this->draw    = intval( $request->input( 'draw' ) );
		$this->start   = $request->input( 'start' );
		$this->length  = $request->input( 'length' );

		$this->orderBy        = $this->fieldList[ $request->input( 'order' )[0]['column'] ]['name'];
		$this->orderDirection = $request->input( 'order' )[0]['dir'];

		// find search value and search column
		foreach ( $this->columns as $column_index => $c ) {
			if ( $c['search']['value'] != '' ) {
				$this->searchValue[]  = $c['search']['value'];
				$this->searchColumn[] = $this->fieldList[ $column_index ]['name'];

			}
		}

		return response()->json( $this->getListItems() );
	}

	public function getListItems() {
		if ( empty( $this->searchColumn ) && empty( $this->searchValue ) ) {
			$items = $this->model;
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

				} else {
					if ( $field['name'] == '_' ) {
						$row[] = 'x';
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

	/**
	 * refer to this document: https://laravel.com/docs/5.4/eloquent-relationships#querying-relations
	 *
	 * @param $field
	 *
	 * @return array: operator for query and relation
	 */
	public function getQueryForField( $field ) {
		// default operator
		$operator = 'like';
		$relation = null;
		$search   = null;
		foreach ( $this->fieldList as $f ) {
			if ( $f['name'] == $field ) {
				switch ( $f['filter_type'] ) {
					case 'text':
						$operator = 'like';
						break;
					case 'select':
						$operator = '=';
						break;
					case 'date-range':
						$operator = 'BETWEEN';
						break;
					default:
						$operator = '=';
				}
				if ( array_key_exists( 'relation', $f ) && ! empty( $f['relation']['object'] ) && ( $f['relation']['type'] == 'n' ) ) {
					$relation = $f['relation']['object'];
					$search   = $f['relation']['search'];
				}
			}
		}

		return [
			'operator' => $operator,
			'relation' => $relation,
			'search'   => $search
		];
	}

	public function continueQuery( $items = null, $index, $column ) {
		/*
		 * using ILIKE replace like to search case-insensitive in Postgress
		 */
		if ( empty( $items ) ) {
			$queryArr = $this->getQueryForField( $column );
			switch ( $queryArr['operator'] ) {
				case 'like':
					if ( empty( $queryArr['relation'] ) ) {
						// search internal table
						$items = $this->model->where( $column, 'like', '%' . $this->searchValue[0] . '%' );
					} else {
						// or search for associates
						$items = $this->model->whereHas( $queryArr['relation'], function ( $query ) use ( $queryArr ) {
							$query->where( $queryArr['search'], 'like', '%' . $this->searchValue[0] . '%' );
						} );
					}
					break;
				case '=':
					if ( empty( $queryArr['relation'] ) ) {
						// search internal table
						$items = $this->model->where( $column, '=', $this->searchValue[0] );
					} else {
						// or search for associates
						$items = $this->model->whereHas( $queryArr['relation'], function ( $query ) use ( $queryArr ) {
							$query->where( $queryArr['search'], '=', $this->searchValue[0] );
						} );
					}
					break;
				case 'BETWEEN':
					if ( empty( $queryArr['relation'] ) ) {
						$items = $this->model->whereBetween( $column, explode( ' - ', $this->searchValue[0] ) );
					}
//					else {
					// todo : future support
//					}
					break;
				default:
					if ( empty( $queryArr['relation'] ) ) {
						// search internal table
						$items = $this->model->where( $column, 'like', '%' . $this->searchValue[0] . '%' );
					} else {
						// or search for associates
						$items = $this->model->whereHas( $queryArr['relation'], function ( $query ) use ( $queryArr ) {
							$query->where( $queryArr['search'], 'like', '%' . $this->searchValue[0] . '%' );
						} );
					}
			}
		} else {
			$queryArr = $this->getQueryForField( $this->searchColumn[ $index ] );
			switch ( $queryArr['operator'] ) {
				case 'like':
					if ( empty( $queryArr['relation'] ) ) {
						// search internal table
						$items = $items->where( $this->searchColumn[ $index ], 'like', '%' . $this->searchValue[ $index ] . '%' );
					} else {
						// or search for associates
						$items = $items->whereHas( $queryArr['relation'], function ( $query ) use ( $queryArr, $index ) {
							$query->where( $queryArr['search'], 'like', '%' . $this->searchValue[ $index ] . '%' );
						} );
					}
					break;
				case '=':
					if ( empty( $queryArr['relation'] ) ) {
						// search internal table
						$items = $items->where( $this->searchColumn[ $index ], '=', $this->searchValue[ $index ] );
					} else {
						// or search for associates
						$items = $items->whereHas( $queryArr['relation'], function ( $query ) use ( $queryArr, $index ) {
							$query->where( $queryArr['search'], '=', $this->searchValue[ $index ] );
						} );
					}
					break;
				case 'BETWEEN':
					if ( empty( $queryArr['relation'] ) ) {
						$items = $items->whereBetween( $this->searchColumn[ $index ], explode( ' - ', $this->searchValue[$index] ) );
					}
//					else {
					// todo : future support
//					}
					break;
				default:
					if ( empty( $queryArr['relation'] ) ) {
						// search internal table
						$items = $items->where( $this->searchColumn[ $index ], 'like', '%' . $this->searchValue[ $index ] . '%' );
					} else {
						// or search for associates
						$items = $items->whereHas( $queryArr['relation'], function ( $query ) use ( $queryArr, $index ) {
							$query->where( $queryArr['search'], 'like', '%' . $this->searchValue[ $index ] . '%' );
						} );
					}
			}
		}

		return $items;
	}
}
