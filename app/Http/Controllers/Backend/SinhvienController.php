<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Giangvien;
use App\Http\Models\Backend\Sinhvien;

class SinhvienController extends Controller
{
    public function index(Request $request) 
    {
        $rs = Sinhvien::select('idmsv','hoten','gioitinh','ngaysinh','nganh','khoa')
                    ->where('type', Sinhvien::TYPE_SV);
        $pageSize = Sinhvien::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize !== $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('idmsv') && $request->idmsv !== "") {
            $filter['idmsv'] = $request->idmsv;
            $rs = $rs->where('idmsv', $filter['idmsv']);
        }

        if($request->has('name') == true && $request->name !== "") {
            $filter['name'] = str_replace("'", "\\'", $request->name);
            $rs = $rs->whereRaw("LOWER(hoten) LIKE CONCAT('%', CONVERT('".strtolower($filter['name'])."', BINARY),'%')");
        }
        
        $data['listSinhvien'] = $rs->orderBy('idmsv','ASC')->orderBy('khoa','ASC')->orderBy('hoten','ASC')->paginate($pageSize);
        $data['listGioitinh'] = Sinhvien::$GIOITINH;
        $data['listKhoa'] = Giangvien::$KHOA;
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
        return view('backend.sinhvien.index', $data);
    }

    public function add(Request $request) 
    {
        if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'idmsv' => 'required',
                'hoten' => 'required',
                'gioitinh' => 'required',
                'nganh' => 'required',
                'khoa' => 'required'               
            ])->validate();
            
            $sinhvien = new Sinhvien;
            $sinhvien->idmsv = $request->idmsv;
            $sinhvien->hoten = $request->hoten;
            $sinhvien->nganh = $request->nganh;
            $sinhvien->gioitinh = $request->gioitinh;
            $sinhvien->ngaysinh = $request->ngaysinh;
            $sinhvien->khoa = $request->khoa;
            $sinhvien->type = Sinhvien::TYPE_SV;
            $sinhvien->status = $request->status;
            $sinhvien->save();
            \Session::flash('msg_sinhvien', "Thêm mới thành công");
            return redirect()->route('backend.sinhvien.index');
        }     
        $data['listStatus'] = Sinhvien::$STATUS;
        /*list khoa*/
        $data['listKhoa'] = Giangvien::$KHOA;
        /*list sex*/
        $data['listGioitinh'] = Sinhvien::$GIOITINH;

        return view('backend.sinhvien.add', $data);
    }

    public function edit(Request $request, $id) 
    {
        $sinhvien = Sinhvien::find($id);
        if($sinhvien) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'idmsv' => 'required',
                    'hoten' => 'required',
                    'gioitinh' => 'required',
                    'nganh' => 'required',
                    'khoa' => 'required'                  
                ])->validate();

                $sinhvien->idmsv = $request->idmsv;
                $sinhvien->hoten = $request->hoten;
                $sinhvien->nganh = $request->nganh;
                $sinhvien->gioitinh = $request->gioitinh;
                $sinhvien->ngaysinh = $request->ngaysinh;
                $sinhvien->khoa = $request->khoa;
                $sinhvien->status = $request->status;
                $sinhvien->save();
                \Session::flash('msg_sinhvien', "Cập nhật thành công");
                return redirect()->route('backend.sinhvien.index');
            }   

            $data['listStatus'] = Sinhvien::$STATUS;
            /*list khoa*/
            $data['listKhoa'] = Giangvien::$KHOA;
            /*list sex*/
            $data['listGioitinh'] = Sinhvien::$GIOITINH;
            $data['model'] = $sinhvien;
            return view('backend.sinhvien.edit', $data);
        } else {
            return redirect()->route('backend.site.error', ['errorCode'=>404, 'msg'=>"Not found request!"]);
        }
    }

    public function reverseStatus(Request $request) 
    {
        $response = [];
        $sinhvien = Sinhvien::find($request->id);
        if($sinhvien) {
            if($sinhvien->status == Sinhvien::STATUS_ACTIVE) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $sinhvien->status = Sinhvien::STATUS_HIDE;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $sinhvien->status = Sinhvien::STATUS_ACTIVE;
            }
            $sinhvien->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        Sinhvien::whereIn('idmsv',$ids)->delete();
        \Session::flash('msg_sinhvien', "Xóa thành công");
        return redirect()->route('backend.sinhvien.index');
    }
}
