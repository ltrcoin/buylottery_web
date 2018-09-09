<?php

namespace App\Http\Controllers\Backend;

use App\Http\Models\Backend\Ticket;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TicketController extends BaseController
{
	protected $model = Ticket::class;
	protected $module_name = 'ticket';
	protected $listTitle = 'label.ticket.title';
	protected $messageName = 'msg_ticket'; // tên của flash message
	protected $initTableScript = 'backend.ticket.initTableScript';

	public function __construct( Container $app )
	{
		parent::__construct( $app );
		$this->fieldList       = [
			[
				'name'        => 'id',
				'title'       => '#',
				'filter_type' => '#',
				'width'       => '2%'
			],
			[
				'name'        => 'game_id',
				'title'       => 'label.ticket.game_name',
				'orderable'   => false,
				'filter_type' => 'select',
				'width'       => '22%',
				'relation'    => [
					'object'  => 'game',
					'display' => 'name',
					'type'    => 1
				],
				'refer'       => [
					'source_table' => 'games',
					'value_column' => 'id',
					'label_column' => 'name'
				]
			],
			[
				'name'        => 'user_id',
				'title'       => 'label.users.title',
				'filter_type' => 'select',
				'width'       => '18%',
				'orderable'   => false,
				'relation'    => [
					'object'  => 'customer',
					'display' => 'fullname',
					'type'    => 1
				],
				'refer'       => [
					'source_table' => 'customers',
					'value_column' => 'id',
					'label_column' => 'fullname',
				]
			],
            [
                'name'        => 'user_id',
                'title'       => 'label.users.email',
                'filter_type' => 'select',
                'width'       => '22%',
                'orderable'   => false,
                'relation'    => [
                    'object'  => 'customer',
                    'display' => 'email',
                    'type'    => 1
                ],
                'refer'       => [
                    'source_table' => 'customers',
                    'value_column' => 'id',
                    'label_column' => 'email',
                ]
            ],
			[
				'name'        => 'numbers',
				'title'       => 'label.ticket.numbers',
				'className'   => 'text-center',
				'filter_type' => '#',
				'width'       => '10%'
			],
			[
				'name'        => 'special_numbers',
				'title'       => 'label.ticket.special_numbers',
				'className'   => 'text-center',
				'filter_type' => '#',
				'width'       => '8%'
			],
            [
                'name' => 'created_at',
                'title' => 'label.ticket.created_at',
                'filter_type' => 'date-range',
                'width' => '18%'
            ]
		];
		$this->buttons         = [];
		$this->defaultOrderBy  = 0;
		$this->defaultOrderDir = 'desc';
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
                        $row[] = Carbon::parse($item->{$field['name']})->format(__('label.datetime_format'));
                    } else {
                        $row[] = $item->{$field['name']};
                    }
                }
            }

            $data[] = $row;
        }

        return $data;
    }
}
