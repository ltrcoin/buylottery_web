<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\User;

class UserController extends BaseController
{
    // index of column in column list
    protected $defaultOrderBy = 0;
    protected $defaultOrderDir = 'desc';
    protected $model = User::class;
    protected $module_name = 'user'; // tên dùng khi đặt tên route, ví dụ backend.user.index -> lấy tên `user`
    protected $messageName = 'msg_user'; // tên của flash message
    protected $toolbar = 'backend.user.toolbar';
    protected $initTableScript = 'backend.user.initTableScript';

    protected $buttons = [
        'createButton' => '/admin/user/add',
        'deleteButton' => '/admin/user/delete'
    ];
    protected $listTitle = 'label.users.list';

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
                'name'        => 'username',
                'title'       => 'label.users.username',
                'filter_type' => 'text',
                'width'       => '20%',
            ],
            [
                'name'        => 'fullname',
                'title'       => 'label.users.name',
                'filter_type' => 'text',
                'width'       => '20%',
            ],
            [
                'name'        => 'email',
                'title'       => 'label.users.email',
                'filter_type' => 'text',
                'width'       => '20%',
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
            //dd($request->all());die();
            /*validate data request*/
            $data = $request->all();

            $messages = [
                'fullname.required' => __('validation.user.fullname'),
                'email.required' => __('validation.user.email'),
                'email.email' => __('validation.user.email2'),
                'password.required' => __('validation.user.password_required'),
                'repassword.required' => __('validation.user.repassword_required'),
                'repassword.same:password' => __('validation.user_same_password'),
            ];
           
            Validator::make($data, [
                'fullname' => 'required',
                'email' => 'required | email',
                'password' => 'required',
                'repassword' => 'required|same:password'     
            ] , $messages)->validate();
            if(User::where('email', $request->email)->first()) {
                return redirect()->route('backend.user.vAdd')->withErrors(['email' => 'Email already exists!'])->withInput();
            }
            try {
                \DB::beginTransaction();
                $user = new User;
                $user->fullname = $request->fullname;
                $user->email = $request->email;
                $user->tel = $request->tel;
                $user->address = $request->address;
                $user->status = User::STATUS_ACTIVE;
                $user->password = bcrypt($request->password);
                $user->save();
               
                \DB::commit();
                \Session::flash('msg_user', "Thêm mới thành công");
                return redirect()->route('backend.user.index');
            } catch (Exception $e) {
                \DB::rollBack();
                return view('backend.site.error');
            }
        }
        return view('backend.user.add');
    }

    public function edit(Request $request, $id) 
    {
        $user = User::find($id);
        if($user) {
            if($request->isMethod('post')) {
                /*validate data request*/
                Validator::make($request->all(), [
                    'fullname' => 'required',
                    'email' => 'required | email'          
                ])->validate();
                if(User::where('email', $request->email)->where('email', '<>', $user->email)->first()) {
                    return redirect()->route('backend.user.vEdit',['id'=>$user->id])->withErrors(['email' => 'Email already exists!']);
                }
                try {
                    \DB::beginTransaction();
                    $user->fullname = $request->fullname;
                    $user->email = $request->email;
                    $user->tel = $request->tel;
                    $user->address = $request->address;
                    $user->status = $request->status;
                    $user->save();
                    \DB::commit();
                    \Session::flash('msg_user', "Cập nhật thành công");
                    return redirect()->route('backend.user.index');
                } catch (Exception $e) {
                    \DB::rollBack();
                    return view('backend.site.error');
                }
            }
            $data['listStatus'] = User::$STATUS;
            $data['model'] = $user;
            return view('backend.user.edit', $data);
        } else {
            return redirect()->route('backend.site.error');
        }
    }

    public function profile(Request $request) 
    {
        if($request->isMethod("post")) {
            /*validate data request*/
            Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required | email'            
            ])->validate();
            if(User::where('email', $request->email)->where('email', '<>', Auth::user()->email)->first()) {
                return redirect()->route('backend.user.vAdd')->withErrors(['email' => 'Email already exists!']);
            }
            $user = Auth::user();
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->tel = $request->tel;
            $user->address = $request->address;
            if ($request->hasFile('introimage')) {
                /*upload file to public/upload/products*/
                $path = $request->file('introimage')->store(
                    'avatar/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );
                if(file_exists($user->introimage)) {
                    unlink($user->introimage);
                }
                $user->introimage = 'upload/'.$path;
            }
            $user->save();
            \Session::flash('msg_editProfile', "Update profile susscess!");
            return redirect()->route('backend.user.profile');
        }
        return view('backend.user.profile');
    }

    public function changePass(Request $request) 
    {
        if($request->isMethod("post")) { 
            /*validate data request*/
            Validator::make($request->all(), [
                'oldPass' => 'required',
                'newPass' => 'required',
                'newPass_confirmation' => 'required | same:newPass'
            ])->validate();
            if(!Hash::check($request->oldPass, Auth::user()->password)) {
                return redirect()->route('backend.user.profile')->withErrors(['oldPass' => 'Old password is not correct']);
            }
            $user = Auth::user();
            $user->password = bcrypt($request->newPass);
            $user->save();
            \Session::flash('msg_changePass', "Change password susscess!");
            return redirect()->route('backend.user.profile');
        }
        return view('backend.user.profile');
    }

    public function reverseStatus(Request $request) 
    {
        $response = [];
        $user = User::find($request->id);
        if($user) {
            if($user->status == User::STATUS_ACTIVE) {
                $response['rm'] = 'fa-check-circle';
                $response['add'] = 'fa-question';
                $user->status = User::STATUS_HIDE;
            } else {
                $response['add'] = 'fa-check-circle';
                $response['rm'] = 'fa-question';
                $user->status = User::STATUS_ACTIVE;
            }
            $user->save();
        } else {
            $response['error'] = true;
        }
        
        return response()->json($response);
    }

    public function delete($id) 
    {
        $ids = explode(",", $id);
        foreach ($ids as $id) {
            $user = User::find($id);
            /*if(file_exists($user->introimage)) {
                unlink($user->introimage);
            }*/
            $user->delete();
        }
        \Session::flash('msg_user', "Xóa thành công");
        return redirect()->route('backend.user.index');
    }
}
