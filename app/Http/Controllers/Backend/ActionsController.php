<?php

namespace App\Http\Controllers\Backend;

use App\Events\Backend\AddAction;
use App\Events\Backend\UpdateAction;
use App\Http\Models\Backend\FormField;
use App\Http\Models\Backend\Organize;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use App\Http\Models\Backend\Action;
use App\Http\Models\Backend\Group;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Excel;
use App;

class ActionsController extends BaseController
{
	// index of column in column list
	protected $defaultOrderBy = 0;
	protected $defaultOrderDir = 'desc';
	protected $model = Action::class;
	protected $module_name = 'actions'; // tên dùng khi đặt tên route, ví dụ backend.task.index -> lấy tên `task`
	protected $messageName = 'msg_actions'; // tên của flash message
	protected $toolbar = 'backend.actions.toolbar';
	protected $listTitle = 'label.actions.list_title';

	protected $buttons = [
		'createButton' => '/admin/actions/add',
		'deleteButton' => '/admin/actions/delete'
	];

	public function __construct( Container $app ) {
		parent::__construct( $app );
		$this->fieldList = [
			[
				'name'        => 'id',
				'title'       => '#',
				'filter_type' => '#',
				'width'       => '2%'
			],
			[
				'name'        => 'name',
				'title'       => 'label.actions.lbl_action_name',
				'filter_type' => 'text',
				'width'       => '30%',
			],
			[
				'name' => 'organization_id',
				'title' => 'label.actions.lbl_organization',
				'orderable'   => false,
				'filter_type' => 'select',
				'width'       => '30%',
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
				'name'        => 'groups',
				'title'       => 'label.actions.lbl_groups',
				'orderable'   => false,
				'filter_type' => '#',
				'width'       => '30%',
				'relation'    => [
					'object'  => 'groups',
					'display' => 'name',
					'search'  => 'id',
					'type'    => 'n'
				],
				'refer'       => [
					'source_table' => 'group',
					'value_column' => 'id',
					'label_column' => 'name'
				]
			],
			[
				'name'        => '_',
				'title'       => '',
				'filter_type' => '#',
				'width'       => '8%'
			]
		];
	}

	public function _createIndexData( $items ) {
		$data = [];
		foreach ( $items as $item ) {
			$row = [];
			foreach ( $this->fieldList as $field ) {
				if ( $field['title'] == 'label.actions.lbl_groups' ) {
					$forAll = $item->for_all_group;
					if ( !$forAll ) {
						$row[] = implode( ', ', $item->groups->pluck( 'name' )->all() );
					} else {
						$row[] = __( 'label.all' ) . ' ' . __( 'label.group.title');
					}
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            /*validate data request*/
            if($request->has('all_group')) {
                Validator::make($request->all(), [
                    'action' => 'required|max:255',
                    'organization' => 'required',
                    'description' => 'required'
                ])->validate();
            }else{
                Validator::make($request->all(), [
                    'action' => 'required|max:255',
                    'organization' => 'required',
                    'group_id' => 'required',
                    'description' => 'required'
                ])->validate();
            }
            if($request->has('form_field')) {
                foreach ($request->form_field as $k => $v){
                    if($v['name'] == null ||  $v['type'] == null){
                        \Session::flash('msg_actions', __( 'flash.input_field' ));
                        return redirect()->route('backend.actions.vAdd');
                    }
                }
            }
            $checkin = ($request->has('checkin')) ? $request->checkin : 0;
            $checkout = ($request->has('checkout')) ? $request->checkout : 0;
            $for_all_group = ($request->has('all_group')) ? $request->all_group : 0;
            $action = new Action;
            $action->name = $request->action;
            $action->organization_id = $request->organization;
            $action->description = $request->description;
            $action->can_checkin = $checkin;
            $action->can_checkout = $checkout;
            $action->for_all_group = $for_all_group;
            $action->save();
            if($request->has('all_group') == false && $request->has('group_id')) {
                $action->groups()->sync($request->group_id);
            }
            event(new AddAction($action));
            if($request->has('form_field')){
                foreach ($request->form_field as $k => $v){
                    $form_field = new FormField();
                    $form_field->field_name =  $v['name'];
                    $form_field->field_type =  $v['type'];
                    $form_field->action_id = $action->id;
                    $form_field->save();
                }
            }
            \Session::flash('msg_actions', __( 'flash.save_success' ));
            return redirect()->route('backend.actions.index');
        }

        /*list organization*/
        $organizations = Organize::all()->pluck('name','id');
        /*list group*/
        $groups = Group::all()->pluck('name','id');
        $data['listOrganization'] = $organizations;
        $data['listGroup'] = $groups;
        $data['buttons'] = [
        	'backButton' => route('backend.actions.index'),
	        'saveButton' => true
        ];
        return view('backend.actions.add', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Backend\Action  $actions
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $action = Action::with('groups')->find($id);
        if($action) {
            if($request->isMethod('post')) {
            	$item = Action::find($id);
            	$oldAction = clone $item;
                /*validate data request*/
                if($request->has('all_group')) {
                    Validator::make($request->all(), [
                        'action' => 'required|max:255',
                        'organization' => 'required',
                        'description' => 'required'
                    ])->validate();
                }else{
                    Validator::make($request->all(), [
                        'action' => 'required|max:255',
                        'organization' => 'required',
                        'group_id' => 'required',
                        'description' => 'required'
                    ])->validate();
                }
                if($request->has('form_field')) {
                    foreach ($request->form_field as $k => $v){
                        if($v['name'] == null ||  $v['type'] == null){
                            \Session::flash('msg_actions', __( 'flash.input_field' ));
                            return redirect()->route('backend.actions.vEdit',['id'=>$id]);
                        }
                    }
                }

                $checkin = ($request->has('checkin')) ? $request->checkin : 0;
                $checkout = ($request->has('checkout')) ? $request->checkout : 0;
                $for_all_group = ($request->has('all_group')) ? $request->all_group : 0;
                $action->name = $request->action;
                $action->organization_id = $request->organization;
                $action->description = $request->description;
                $action->can_checkin = $checkin;
                $action->can_checkout = $checkout;
                $action->for_all_group = $for_all_group;
                $action->save();
                if($request->has('all_group')){
                    $action->groups()->detach();
                }else{
                    $action->groups()->sync($request->group_id);
                }
                if($request->has('form_field')){
                    $form_field = FormField::select('field_name','field_type')->where('action_id', $id)->delete();
                    foreach ($request->form_field as $k => $v){
                        $form_field = new FormField();
                        $form_field->field_name =  $v['name'];
                        $form_field->field_type =  $v['type'];
                        $form_field->action_id = $action->id;
                        $form_field->save();
                    }
                }
	            event(new UpdateAction( $oldAction, $action ));
	            \Session::flash('msg_actions', __( 'flash.edit_success' ));
                return redirect()->route('backend.actions.index');
            }
            /*list organization*/
            $organizations = Organize::all()->pluck('name','id');
            $form_field = FormField::select('field_name','field_type')->where('action_id', $id)->get();
            /*list group*/
            $groups = Group::all()->pluck('name','id');
            $data['listOrganization'] = $organizations;
            $data['listGroup'] = $groups;
            $data['model'] = $action;
            $data['formField'] = $form_field;
            if (App::isLocale('en')) {
                $data['listType'] = FormField::$fieldTypeEn;
            }
            if (App::isLocale('vi')) {
                $data['listType'] = FormField::$fieldTypeVi;
            }
            $mgroups = [];
            foreach ($data['model']['groups'] as $key=>$value){
                array_push($mgroups,$value['id']);
            }
            $data['mgroups'] = $mgroups;
	        $data['buttons'] = [
		        'backButton' => route('backend.actions.index'),
		        'saveButton' => true
	        ];
            return view('backend.actions.edit', $data);
        }else {
            return redirect()->route('backend.site.error', ['errorCode'=>404, 'msg'=>"Not found request!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Backend\Action  $actions
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $action = Action::find($id);
            $action->delete();
        }
        \Session::flash('msg_actions', __( 'flash.delete_success' ));
        return redirect()->route('backend.actions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Backend\Action  $actions
     * @return \Illuminate\Http\Response
     */
    public function detail( $id )
    {
        $item = Action::findOrFail($id);
        $form_field = FormField::select('field_name','field_type')->where('action_id', $id)->get();
	    if (App::isLocale('en')) {
		    $listType = FormField::$fieldTypeEn;
	    }
	    if (App::isLocale('vi')) {
		    $listType = FormField::$fieldTypeVi;
	    }
	    foreach ( $form_field as $index => $field ) {
		    $form_field[$index]['field_type'] = $listType[$form_field[$index]['field_type']];
	    }
        return view('backend.actions.detail', ['item' => $item, 'form_field' => $form_field]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Backend\Action  $actions
     * @return \Illuminate\Http\Response
     */
    public function downloadForm( $id )
    {
        $form_field = FormField::select('field_name','field_type')->where('action_id', $id)->get()->toArray();
	    if (App::isLocale('en')) {
		    $listType = FormField::$fieldTypeEn;
	    }
	    if (App::isLocale('vi')) {
		    $listType = FormField::$fieldTypeVi;
	    }
	    foreach ( $form_field as $index => $field ) {
		    $form_field[$index]['field_type'] = $listType[$form_field[$index]['field_type']];
	    }
        Excel::create('report_form_action_' . $id, function($excel) use($form_field){
            $excel->sheet('Sheet 1', function($sheet) use($form_field){
                $sheet->fromArray($form_field);
            });
        })->export('xlsx');
    }
}
