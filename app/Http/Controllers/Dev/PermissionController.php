<?php

namespace App\Http\Controllers\Dev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Backend\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
    	$rs = Permission::select("*");

        $pageSize = Permission::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize != $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('name') == true && $request->name != "") {
            $filter['name'] = $request->name;
            $rs = $rs->where('permission_id', 'like', '%'.$filter['name'].'%');
        }
        
        $data['listPermission'] = $rs->orderBy('permission_id','ASC')->paginate($pageSize);
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
    	return view('dev.permission.index', $data);
    }

    public function add(Request $request)
    {
    	if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'type' => 'required'              
            ])->validate();
            if(Permission::find($request->name)) {
                return redirect()->route('dev.permission.vAdd')->withErrors("Permission đã tồn tại!");
            }
            $permission = new Permission;
            $permission->permission_id = $request->name;
            $permission->description = $request->description;
            $permission->type = $request->type;
            $permission->save();
            return redirect()->route('dev.permission.index');
        }
        $listType = Permission::$TYPE['vi'];
        return view('dev.permission.add', ['listType' => $listType]);
    }

    public function edit(Request $request, $id)
    {
    	$permission = Permission::find($id);
        if($permission) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'name' => 'required',
                    'description' => 'required',
                    'type' => 'required'                
                ])->validate();
	            $permission->permission_id = $request->name;
            	$permission->description = $request->description;
                $permission->type = $request->type;
	            $permission->save();
                return redirect()->route('dev.permission.index');
            }
            $data['model'] = $permission;
            $data['listType'] = Permission::$TYPE['vi'];
            return view('dev.permission.edit', $data);
        } else {
            return redirect()->route('dev.site.error');
        }
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        Permission::whereIn('permission_id', $ids)->delete();
        \Session::flash('msg_permission', "Xóa thành công");
        return redirect()->route('dev.permission.index');
    }

}
