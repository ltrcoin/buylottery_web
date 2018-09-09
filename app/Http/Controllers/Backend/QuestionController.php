<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\Question;

class QuestionController extends Controller
{
    public function index(Request $request) 
    {   
        $rs = Question::select('*');

        $pageSize = Question::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize != $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }

        if($request->has('type') && $request->type != 0) {
            $filter['type'] = $request->type;
            $rs = $rs->where('type', $filter['type']);
        }

        if($request->has('name') == true && $request->name != "") {
            $filter['name'] = $request->name;
            $rs = $rs->where('name', 'like', '%'.$filter['name'].'%');
        }
        $data['listQuestion'] = $rs->orderBy('type','ASC')
                                    ->orderBy('object','ASC')
                                    ->orderBy('id','DESC')
                                    ->paginate($pageSize);
        $data['listType'] = Question::$TYPE; 
        /*list obj*/
        $data['listObj'] = Question::$DOITUONG;
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
    	return view('backend.question.index', $data);
    }

    public function add(Request $request) 
    {
        if($request->isMethod('post')) {
        	/*validate data request*/
            Validator::make($request->all(), [
                'name'   => 'required',
                'type'   => 'required',
                'object' => 'required'          
            ])->validate();
            $question = new Question;
            $question->name   = $request->name;
            $question->type   = $request->type;
            $question->object = $request->object;
            $question->status = Question::STATUS_ACTIVE;
            $question->save();
            \Session::flash('msg_question', "Thêm mới thành công");
            return redirect()->route('backend.question.index');
        }     
        
        /*list obj*/
        $data['listObj'] = Question::$DOITUONG;
        /*list type*/
        $data['listType'] = Question::$TYPE;
    	return view('backend.question.add', $data);
    }

    public function edit(Request $request, $id) 
    {
        $question = Question::find($id);
        if($question) {
	        if($request->isMethod('post')) {
	        	/*validate data request*/
	            Validator::make($request->all(), [
                    'name'   => 'required',
                    'type'   => 'required',
                    'object' => 'required'              
                ])->validate();	            
	            $question->name   = $request->name;
                $question->type   = $request->type;
                $question->object = $request->object;
	            $question->save();
                \Session::flash('msg_question', "Cập nhật thành công");
	            return redirect()->route('backend.question.index');
	        }
	        /*list obj*/
            $data['listObj'] = Question::$DOITUONG;
	        /*list type*/
	        $data['listType'] = Question::$TYPE;  
            $data['model'] = $question;
	    	return view('backend.question.edit', $data);
	    } else {
	    	return redirect()->route('backend.site.error', ['errorCode'=>404, 'msg'=>"Not found request!"]);
	    }
    }

    public function reverseStatus(Request $request) 
    {
        $response = [];
        $question = Question::find($request->id);
        if($question) {
            if($question->status == Question::STATUS_ACTIVE) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $question->status = Question::STATUS_HIDE;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $question->status = Question::STATUS_ACTIVE;
            }
            $question->save();
        } else {
            $response['error'] = true;
        }
        
    	return response()->json($response);
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        Question::whereIn('id', $ids)->delete();
        \Session::flash('msg_question', "Xóa thành công");
        return redirect()->route('backend.question.index');
    }
}