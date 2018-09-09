<?php

namespace App\Http\Controllers\Dev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\Dev\Role;
use App\Http\Models\Dev\RoleItem;

class RoleController extends Controller
{
    public function indexGroup(Request $request)
    {
    	$rs = Role::select("*");

        $pageSize = Role::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize != $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('name') == true && $request->name != "") {
            $filter['name'] = $request->name;
            $rs = $rs->where('name', 'like', '%'.$filter['name'].'%');
        }
        
        $data['listRoleGroup'] = $rs->orderBy('id','ASC')->paginate($pageSize);
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
    	return view('dev.role.indexGroup', $data);
    }

    public function indexItem(Request $request)
    {
    	$rs = RoleItem::select("*");

        $pageSize = RoleItem::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize != $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('name') == true && $request->name != "") {
            $filter['name'] = $request->name;
            $rs = $rs->where('name', 'like', '%'.$filter['name'].'%');
        }
        
        $data['listRoleItem'] = $rs->orderBy('id','ASC')->paginate($pageSize);
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
    	return view('dev.role.indexItem', $data);
    }

    public function addGroup(Request $request)
    {
    	if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'name' => 'required'              
            ])->validate();
            $role = new Role;
            $role->name = $request->name;
            $role->role = implode(",", $request->role);
            $role->save();
            return redirect()->route('dev.role.indexGroup');
        }
        $data['roleItem'] = RoleItem::orderBy('id', 'ASC')->get();
        return view('dev.role.addGroup', $data);
    }

    public function addItem(Request $request)
    {
    	if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'name' => 'required'              
            ])->validate();
            
            $role = new RoleItem;
            $role->name = $request->name;
            $role->description = $request->description;
            $role->save();
            return redirect()->route('dev.role.indexItem');
        }

        return view('dev.role.addItem');
    }

    public function editGroup(Request $request, $id)
    {
    	$role = Role::find($id);
        if($role) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'name' => 'required'                
                ])->validate();
	            $role->name = $request->name;
            	$role->role = implode(",", $request->role);
	            $role->save();
                return redirect()->route('dev.role.indexGroup');
            }
            $data['roleItem'] = RoleItem::orderBy('id', 'ASC')->get();
            $data['model'] = $role;
            $data['roles'] = explode(",", $role->role);
            return view('dev.role.editGroup', $data);
        } else {
            return redirect()->route('dev.site.error');
        }
    }

    public function editItem(Request $request, $id)
    {
    	$role = RoleItem::find($id);
        if($role) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'name' => 'required'                
                ])->validate();
	            $role->name = $request->name;
            	$role->description = $request->description;
	            $role->save();
                return redirect()->route('dev.role.indexItem');
            }
            $data['model'] = $role;
            return view('dev.role.editItem', $data);
        } else {
            return redirect()->route('dev.site.error');
        }
    }

    public function deleteGroup($id) 
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $role = Setting::find($id);
            $role->delete();
        }
        \Session::flash('msg_roleGroup', "Xóa thành công");
        return redirect()->route('dev.role.indexGroup');
    }

    public function deleteItem($id) 
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $role = RoleItem::find($id);
            $role->delete();
        }
        \Session::flash('msg_roleItem', "Xóa thành công");
        return redirect()->route('dev.role.indexItem');
    }

}
