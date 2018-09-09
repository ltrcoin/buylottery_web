<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\News;

class NewsController extends Controller
{
    public function index(Request $request) 
    {
        $rs = News::select('*');

        $pageSize = News::PAGE_SIZE;
        $filter = [];
        if($request->has('pageSize') && $request->pageSize !== $pageSize) {
            $filter['pageSize'] = $request->pageSize;
            $pageSize = $request->pageSize;
        }
        if($request->has('name') == true && $request->name !== "") {
            $filter['name'] = $request->name;
            $rs = $rs->whereRaw("LOWER(tbl_news.name) LIKE CONCAT('%', CONVERT('".strtolower($filter['name'])."', BINARY),'%')");
        }
        
        $data['listNews'] = $rs->orderBy('news.id','DESC')->paginate($pageSize);
        $data['filter'] = $filter;
        $data['pageSize'] = $pageSize;
    	return view('backend.news.index', $data);
    }

    public function add(Request $request) 
    {
        if($request->isMethod('post')) {
            /*validate data request*/
            Validator::make($request->all(), [
                'name' => 'required | max:255',
                'content' => 'required',
                'introtext' => 'required | max:350',
                'introimage' => 'required',
                'attactfile' => 'required'          
            ])->validate();
            
            $news = new News;
            $news->name = $request->name;
            $news->alias = $request->alias;
            $news->introtext = $request->introtext;
            $news->content = $request->content;
            $news->status = $request->status;
            /*upload file to public/upload/news*/
            if ($request->hasFile('introimage')) {
                $path = $request->file('introimage')->store(
                    'news/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );
                $news->introimage = 'upload/'.$path;
            }
            /*upload file to public/upload/attachment*/
            if($request->hasFile('attactfile')) {
                $pathAttact = $request->file('attactfile')->storeAs(
                    'attachment/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), str_replace("-", "_", $request->alias)."_".time().".".$request->file("attactfile")->getClientOriginalExtension(),'upload'
                );
                $news->attactfile = 'upload/'.$pathAttact;
            }
            $news->save();
            return redirect()->route('backend.news.index');
        }     
        $data['listStatus'] = News::$STATUS;
        return view('backend.news.add', $data);
    }

    public function edit(Request $request, $id) 
    {
        $news = News::find($id);
        if($news) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'name' => 'required | max:255',
                    'content' => 'required',
                    'introtext' => 'required | max:350',
                    'introimage' => 'required',
                    'attactfile' => 'required'              
                ])->validate();

                $news->name = $request->name;
                $news->alias = $request->alias;
                $news->introtext = $request->introtext;
                $news->content = $request->content;
                $news->status = $request->status; 
                if ($request->hasFile('introimage')) {
                    /*upload file to public/upload/newss*/
                    $path = $request->file('introimage')->store(
                        'news/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                    );
                    if(file_exists($news->introimage)) {
                        unlink($news->introimage);
                    }
                    $news->introimage = 'upload/'.$path;
                }
                /*upload file to public/upload/attachment*/
                if($request->hasFile('attactfile')) {
                    $pathAttact = $request->file('attactfile')->storeAs(
                        'attachment/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), str_replace("-", "_", $request->alias)."_".time().".".$request->file("attactfile")->getClientOriginalExtension(),'upload'
                    );
                    if(file_exists($news->attactfile)) {
                        unlink($news->attactfile);
                    }
                    $news->attactfile = 'upload/'.$pathAttact;
                }
                $news->save();
                return redirect()->route('backend.news.index');
            }     
            $data['listStatus'] = News::$STATUS;
            $data['model'] = $news;
            return view('backend.news.edit', $data);
        } else {
            return redirect()->route('backend.site.error', ['errorCode'=>404, 'msg'=>"Not found request!"]);
        }
    }

    public function reverseStatus(Request $request) 
    {
        $response = [];
        $news = News::find($request->id);
        if($news) {
            if($news->status == News::STATUS_ACTIVE) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $news->status = News::STATUS_HIDE;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $news->status = News::STATUS_ACTIVE;
            }
            $news->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $news = News::find($id);
            if(file_exists($news->introimage)) {
                unlink($news->introimage);
            }
            if(file_exists($news->attactfile)) {
                unlink($news->attactfile);
            }
            $news->delete();
        }
        \Session::flash('msg_news', "Xóa thành công");
        return redirect()->route('backend.news.index');
    }
}
