<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\Permission;
use App\Http\Models\Backend\GroupPermission;
use App\Http\Models\Backend\Organize;

class GroupController extends BaseController
{
// index of column in column list
    protected $defaultOrderBy = 0;
    protected $defaultOrderDir = 'desc';
    protected $model = Group::class;
    protected $module_name = 'group'; // tên dùng khi đặt tên route, ví dụ backend.group.index -> lấy tên `group`
    protected $messageName = 'msg_group'; // tên của flash message
    protected $toolbar = 'backend.group.toolbar';
    protected $initTableScript = 'backend.group.initTableScript';

    protected $buttons = [
        'createButton' => '/admin/group/add',
        'deleteButton' => '/admin/group/delete'
    ];
    protected $listTitle = 'label.group.list';

    public function __construct(Container $app)
    {
        parent::__construct($app);
        $this->fieldList = [
            [
                'name'        => 'id',
                'title'       => '#',
                'filter_type' => '#',
                'width'       => '2%'
            ],
            [
                'name'        => 'name',
                'title'       => 'label.group.name',
                'filter_type' => 'text',
                'width'       => '30%',
            ],
            [
                'name'        => 'code',
                'title'       => 'label.group.code',
                'filter_type' => 'text',
                'width'       => '30%',
            ],
            [
                'name' => 'organization_id',
                'title' => 'label.group.organization',
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
                'name' => 'checkin',
                'title' => 'label.group.checkin',
                'orderable' => false,
                'filter_type' => '#',
                'width' => '5%',
                'className' => 'text-center'
            ],
            [
                'name' => 'checkout',
                'title' => 'label.group.checkout',
                'orderable' => false,
                'filter_type' => '#',
                'width' => '5%',
                'className' => 'text-center'
            ],
            [
                'name' => 'confirm',
                'title' => 'label.group.confirm',
                'orderable' => false,
                'filter_type' => '#',
                'width' => '5%',
                'className' => 'text-center'
            ],
            [
                'name' => 'reject',
                'title' => 'label.group.reject',
                'orderable' => false,
                'filter_type' => '#',
                'width' => '5%',
                'className' => 'text-center'
            ],
            [
                'name'        => '_',
                'title'       => '',
                'filter_type' => '#',
                'width'       => '8%'
            ]
        ];
    }

    public function add(Request $request) 
    {
        if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'group_organization' => 'required',
                'group_code' => 'required|max:150',
                'group_name' => 'required|max:255',
                'group_description' => 'required'           
            ])->validate();
            try {
                \DB::beginTransaction();
                $group = new Group;
                $group->organization_id = $request->group_organization;
                $group->code = $request->group_code;
                $group->name = $request->group_name;
                $group->description = $request->group_description;
                $group->checkin = $request->has('checkin') ? 1 : 0;
                $group->checkout = $request->has('checkout') ? 1 : 0;
                $group->confirm = $request->has('confirm') ? 1 : 0;
                $group->reject = $request->has('reject') ? 1 : 0;
                $group->save();
                $permissions = [];
                if($request->has('permission'))
                    $permissions = Permission::whereIn('type', $request->permission)->orderBy('permission_id', 'ASC')->get();
                $data_insert = [];
                foreach ($permissions as $item) {
                    $data_item = [];
                    $data_item['group_id'] = $group->id;
                    $data_item['permission_id'] = $item->permission_id;
                    $data_item['type'] = $item->type;
                    $data_insert[] = $data_item;
                }
                /*add default role sitecontroller*/
                $per_site = [
                    'backend.site.index',
                    'backend.site.logout',
                    'backend.site.error',
                    'backend.site.uploadImageContent',
                    'backend.config.language'
                ];
                if(Auth::user()->is_admin == 1) {
                    $per_site[] = 'backend.reports.index';
                    $per_site[] = 'backend.reports.startup_count';
                    $per_site[] = 'backend.reports.maps';
                }
                foreach ($per_site as $item) {
                    $data_item = [];
                    $data_item['group_id'] = $group->id;
                    $data_item['permission_id'] = $item;
                    $data_item['type'] = 'module.site.user';
                    $data_insert[] = $data_item;
                }
                GroupPermission::insert($data_insert);
                \DB::commit();
                \Session::flash('msg_group', __('messages.add_success'));
                return redirect()->route('backend.group.index');
            } catch(Exception $e) {
                \DB::rollback();
                return redirect()->route('admin.group.vAdd')->withErrors(['error' => $e->getMessage()]);
            }
        }     
        $lang = !is_null(\Loc::current()) ? \Loc::current() : 'vi';
        $data['listPermission'] = isset(Permission::$TYPE[$lang]) ? Permission::$TYPE[$lang] : Permission::$TYPE['vi'];
        $data['listOrganization'] = Organize::select('id', 'name')
                                            ->orderBy('name', 'ASC')
                                            ->get();
        $data['buttons'] = [
            'saveButton' => true,
            'backButton' => route( 'backend.group.index' )
        ];
        return view('backend.group.add', $data);
    }

    public function edit(Request $request, $id) 
    {
        $group = Group::find($id);
        if($group) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'group_organization' => 'required',
                    'group_code' => 'required|max:150',
                    'group_name' => 'required|max:255',
                    'group_description' => 'required'
                ])->validate();

                try {
                \DB::beginTransaction();
                    $group->organization_id = $request->group_organization;
                    $group->code = $request->group_code;
                    $group->name = $request->group_name;
                    $group->description = $request->group_description;
                    $group->checkin = $request->has('checkin') ? 1 : 0;
                    $group->checkout = $request->has('checkout') ? 1 : 0;
                    $group->confirm = $request->has('confirm') ? 1 : 0;
                    $group->reject = $request->has('reject') ? 1 : 0;
                    $group->save();
                    GroupPermission::where('group_id', $group->id)->delete();
                    $permissions = [];
                    if($request->has('permission'))
                        $permissions = Permission::whereIn('type', $request->permission)->orderBy('permission_id', 'ASC')->get();
                    $data_insert = [];
                    foreach ($permissions as $item) {
                        $data_item = [];
                        $data_item['group_id'] = $group->id;
                        $data_item['permission_id'] = $item->permission_id;
                        $data_item['type'] = $item->type;
                        $data_insert[] = $data_item;
                    }
                    /*add default role sitecontroller*/
                    $per_site = [
                        'backend.site.index',
                        'backend.site.logout',
                        'backend.site.error',
                        'backend.site.uploadImageContent',
                        'backend.config.language'
                    ];
                    if(Auth::user()->is_admin == 1) {
                        $per_site[] = 'backend.reports.index';
                        $per_site[] = 'backend.reports.startup_count';
                        $per_site[] = 'backend.reports.maps';
                    }
                    foreach ($per_site as $item) {
                        $data_item = [];
                        $data_item['group_id'] = $group->id;
                        $data_item['permission_id'] = $item;
                        $data_item['type'] = 'module.site.user';
                        $data_insert[] = $data_item;
                    }
                    GroupPermission::insert($data_insert);
                    \DB::commit();
                    \Session::flash('msg_group', __('messages.edit_success'));
                    return redirect()->route('backend.group.index');
                } catch(Exception $e) {
                    \DB::rollback();
                    return redirect()->route('admin.group.vAdd')->withErrors(['error' => $e->getMessage()]);
                }
            }   
            $lang = !is_null(\Loc::current()) ? \Loc::current() : 'vi';
            $data['listPermission'] = isset(Permission::$TYPE[$lang]) ? Permission::$TYPE[$lang] : Permission::$TYPE['vi'];
            $data['model'] = $group;
            $data['roles'] = GroupPermission::where('group_id', $group->id)->distinct('type')->pluck('type')->toArray();
            $data['listOrganization'] = Organize::select('id', 'name')
                                                ->orderBy('name', 'ASC')
                                                ->get();
            $data['buttons'] = [
                'saveButton' => true,
                'backButton' => route( 'backend.group.index' )
            ];
            return view('backend.group.edit', $data);
        } else {
            return redirect()->route('backend.site.error', ['errorCode'=>404, 'msg'=>"Not found request!"]);
        }
    }

    public function detail(Request $request, $id) 
    {
        $group = Group::findOrFail($id);
        if($group) {   
            $lang = !is_null(\Loc::current()) ? \Loc::current() : 'vi';
            $data['listPermission'] = isset(Permission::$TYPE[$lang]) ? Permission::$TYPE[$lang] : Permission::$TYPE['vi'];
            $data['model'] = $group;
            $data['roles'] = GroupPermission::where('group_id', $group->id)->distinct('type')->pluck('type')->toArray();
            return view('backend.group.detail', $data);
        }
    }

    public function reverseCheckin(Request $request) 
    {
        $response = [];
        $group = Group::find($request->id);
        if($group) {
            if($group->checkin == 1) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $group->checkin = 0;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $group->checkin = 1;
            }
            $group->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }
    public function reverseCheckout(Request $request) 
    {
        $response = [];
        $group = Group::find($request->id);
        if($group) {
            if($group->checkout == 1) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $group->checkout = 0;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $group->checkout = 1;
            }
            $group->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }
    public function reverseConfirm(Request $request) 
    {
        $response = [];
        $group = Group::find($request->id);
        if($group) {
            if($group->confirm == 1) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $group->confirm = 0;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $group->confirm = 1;
            }
            $group->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }
    public function reverseReject(Request $request) 
    {
        $response = [];
        $group = Group::find($request->id);
        if($group) {
            if($group->reject == 1) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $group->reject = 0;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $group->reject = 1;
            }
            $group->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        Group::whereIn('id',$ids)->delete();
        \Session::flash('msg_group', __('messages.delete_success'));
        return redirect()->route('backend.group.index');
    }

    public function autocomplete($keyword) {
        $rs = Group::select('group.id', 'group.name as value')
                        ->leftJoin('organize', 'organize.id', '=', 'group.organization_id')
                        ->whereRaw('LOWER(tbl_group.name) like \'%'.strtolower($keyword).'%\'')
                        ->orWhereRaw('LOWER(tbl_organize.name) like \'%'.strtolower($keyword).'%\'')
                        ->take(10)
                        ->get();
        return response()->json($rs);
    }

}
