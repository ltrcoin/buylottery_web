<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Giangvien;

class GiangvienController extends Controller
{
    public function index(Request $request) 
    {   
        $rs = Giangvien::select('*');
        $pageSize = Giangvien::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize != $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('khoa') && $request->khoa != 0) {
            $filter['khoa'] = $request->khoa;
            $rs = $rs->where('khoa', $filter['khoa']);
        }

        if($request->has('name') == true && $request->name != "") {
            $filter['name'] = $request->name;
            $rs = $rs->where('hoten', 'like', '%'.$filter['name'].'%');
        }
        $data['listGiangvien'] = $rs->orderBy('id','DESC')
                                    ->paginate($pageSize);
        $data['arrKhoa'] = Giangvien::$KHOA; 
        /*list status*/
        $data['listStatus'] = Giangvien::$STATUS;
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
    	return view('backend.giangvien.index', $data);
    }

    public function add(Request $request) 
    {
        if($request->isMethod('post')) {
        	/*validate data request*/
            Validator::make($request->all(), [
                'hoten' => 'required',
                'trinhdo' => 'required',
                'khoa' => 'required',
                'status' => 'required'                
            ])->validate();

            $giangvien = new Giangvien;
            $giangvien->hoten = $request->hoten;
            $giangvien->trinhdo = $request->trinhdo;
            $giangvien->khoa = $request->khoa;
            /*upload file to public/upload/giangvien*/
            $path = $request->file('introimage')->store(
                'giangvien/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
            );
            $giangvien->introimage = 'upload/'.$path;
            $giangvien->status = $request->status;
            $giangvien->khoinganh = $request->khoinganh;
            $giangvien->save();
            \Session::flash('msg_giangvien', "Thêm mới thành công");
            return redirect()->route('backend.giangvien.index');
        }     
        
        /*list status*/
        $data['listStatus'] = Giangvien::$STATUS;
        /*array khoa*/
        $data['arrKhoa'] = Giangvien::$KHOA;
        /*list trinhdo*/
        $data['listTrinhdo'] = Giangvien::$TRINHDO;

    	return view('backend.giangvien.add', $data);
    }

    public function edit(Request $request, $id) 
    {
        $giangvien = Giangvien::find($id);
        if($giangvien) {
	        if($request->isMethod('post')) {
	        	/*validate data request*/
	            Validator::make($request->all(), [
                    'hoten' => 'required',
                    'trinhdo' => 'required',
                    'khoa' => 'required',
                    'status' => 'required'               
                ])->validate();

	            
	            $giangvien->hoten = $request->hoten;
                $giangvien->trinhdo = $request->trinhdo;
                $giangvien->khoa = $request->khoa;
                if ($request->hasFile('introimage')) {
                    /*upload file to public/upload/giangvien*/
                    $path = $request->file('introimage')->store(
                        'giangvien/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                    );
                    if(file_exists($giangvien->introimage)) {
                        unlink($giangvien->introimage);
                    }
                    $giangvien->introimage = 'upload/'.$path;
                }
                $giangvien->status = $request->status;
                $giangvien->khoinganh = $request->khoinganh;
                $giangvien->save();
                \Session::flash('msg_giangvien', "Cập nhật thành công");
	            return redirect()->route('backend.giangvien.index');
	        }    
	        /*list status*/
	        $data['listStatus'] = Giangvien::$STATUS;
	        /*array khoa*/
	        $data['arrKhoa'] = Giangvien::$KHOA;   
            /*list trinhdo*/
            $data['listTrinhdo'] = Giangvien::$TRINHDO;
            $data['model'] = $giangvien;
	    	return view('backend.giangvien.edit', $data);
	    } else {
	    	return redirect()->route('backend.site.error', ['errorCode'=>404, 'msg'=>"Not found request!"]);
	    }
    }

    public function reverseStatus(Request $request) 
    {
        $response = [];
        $category = Giangvien::find($request->id);
        if($category) {
            if($category->status == Giangvien::STATUS_ACTIVE) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $category->status = Giangvien::STATUS_HIDE;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $category->status = Giangvien::STATUS_ACTIVE;
            }
            $category->save();
        } else {
            $response['error'] = true;
        }
        
    	return response()->json($response);
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $giangvien = Giangvien::find($id);
            if(file_exists($giangvien->introimage)) {
                unlink($giangvien->introimage);
            }
            $giangvien->delete();
        }
        \Session::flash('msg_giangvien', "Xóa thành công");
        return redirect()->route('backend.giangvien.index');
    }
}