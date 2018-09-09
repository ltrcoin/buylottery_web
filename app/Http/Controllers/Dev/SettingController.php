<?php

namespace App\Http\Controllers\Dev;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Dev\Setting;

class SettingController extends Controller
{
    public function index(Request $request) 
    {
        $rs = Setting::where('language', \Lang::getLocale());

        $pageSize = Setting::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize != $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('name') == true && $request->name != "") {
            $filter['name'] = $request->name;
            $rs = $rs->where('name', 'like', '%'.$filter['name'].'%');
        }

        if($request->has('type') == true && $request->type != "") {
            $filter['type'] = $request->type;
            $rs = $rs->where('type', $request->type);
        }
        
        $data['listSetting'] = $rs->orderBy('id','DESC')->paginate($pageSize);
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
        $data['listType'] = Setting::$TYPE;
    	return view('dev.setting.index', $data);
    }

    public function add(Request $request) 
    {
        if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'name' => 'required',
                'content' => 'required'               
            ])->validate();
            
            $setting = new Setting;
            $setting->name = $request->name;
            $setting->content = $request->content;
            $setting->type = $request->type;
            $setting->description = $request->description;
            $setting->language = config('app.locale_admin');
            $setting->save();
            return redirect()->route('dev.setting.index');
        } 
        $data['listType'] = Setting::$TYPE;

        return view('dev.setting.add', $data);
    }

    public function edit(Request $request, $id) 
    {
        $setting = Setting::find($id);
        if($setting) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'content' => 'required'                
                ])->validate();
	            $setting->name = $request->name;
                $setting->content = $request->content;
                $setting->type = $request->type;
                $setting->description = $request->description;
	            $setting->language = config('app.locale_admin');
	            $setting->save();
                return redirect()->route('dev.setting.index');
            }
            $data['listType'] = Setting::$TYPE;
            $data['model'] = $setting;
            return view('dev.setting.edit', $data);
        } else {
            return redirect()->route('dev.site.error');
        }
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $setting = Setting::find($id);
            $setting->delete();
        }
        \Session::flash('msg_setting', "Xóa thành công");
        return redirect()->route('dev.setting.index');
    }
}
