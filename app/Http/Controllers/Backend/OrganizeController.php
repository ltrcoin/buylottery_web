<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\User;
use App\Http\Models\Backend\City;
use App\Http\Models\Backend\Organize;
use App\Http\Models\Backend\LegalRepresentative;
use App\Http\Models\Backend\Dropdown;
use App\Http\Models\Backend\Group;
use App\Http\Models\Backend\GroupUser;
use Yajra\DataTables\DataTables;
use DB;
use Carbon\Carbon;
use Loc;
use Excel;
use App\Http\Services\Common;

class OrganizeController extends BaseController
{
    protected $common;
    // index of column in column list
    protected $defaultOrderBy = 0;
    protected $defaultOrderDir = 'desc';
    protected $model = Organize::class;
    protected $module_name = 'organize'; // tên dùng khi đặt tên route, ví dụ backend.organize.index -> lấy tên `organize`
    protected $messageName = 'msg_organization'; // tên của flash message
    protected $toolbar = 'backend.organize.toolbar';
    protected $initTableScript = 'backend.organize.initTableScript';

    protected $listTitle = 'label.organize.organize_list';
    protected $listView = 'backend.organize.list';
    protected $customScript = ['backend.organize.import_script'];

    public function __construct(Container $app, Common $common)
    {
        parent::__construct($app);
        $this->common = $common;
        $importLabel = __('label.organize.import_organize', [], \Session::get('locale'));
	    $this->buttons = [
	    'createButton' => '/admin/organize/create',
	    'deleteButton' => '/admin/organize/delete',
	    'customControls' => [
		    '<a style="margin-right: 10px" data-toggle="modal" data-target="#myModal" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> ' . $importLabel . '</a>'
	    ]
    ];
        $this->fieldList = [
            [
                'name'        => 'id',
                'title'       => '#',
                'filter_type' => '#',
                'width'       => '2%'
            ],
            [
                'name'        => 'name',
                'title'       => 'label.organize.name_organize',
                'filter_type' => 'text',
                'width'       => '30%',
            ],
            [
                'name'        => 'level',
                'title'       => 'label.organize.level',
                'filter_type' => 'text',
                'width'       => '15%',
                'className'   => 'text-center'
            ],
            [
                'name'        => 'type',
                'title'       => 'label.organize.type',
                'filter_type' => 'text',
                'width'       => '15%',
                'className'   => 'text-center'
            ],
            [
                'name'        => 'parent_id',
                'title'       => 'label.organize.parent',
                'filter_type' => '#',
                'width'       => '30%',
            ],
            [
                'name'        => '_',
                'title'       => '',
                'filter_type' => '#',
                'width'       => '8%'
            ]
        ];
    }

    public function _createIndexData($items)
    {
        $data = [];
        foreach ( $items as $item ) {
            $row = [];
            foreach ( $this->fieldList as $field ) {
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
                    if ( $field['name'] == '_' ) {
                        $row[] = 'x';
                    } elseif($field['filter_type'] == 'date-range') {
                        // display date data in localize format
                        $row[] = Carbon::parse($item->{$field['name']})->format(__('label.date_format'));
                    } elseif ($field['name'] == 'parent_id') {
                        if( !empty( $item->parent_id )) {
                            $row[] = Organize::find($item->parent_id)->first()->name;
                        } else {
                            $row[] = '';
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

    public function ajaxIndex(){
        $users = DB::table('organize as a')
        ->leftJoin('organize as b', 'b.id', '=', 'a.parent_id')
        ->whereNull('a.deleted_at')
        ->select('a.id', 'a.name' , 'a.level' , 'a.type' , 'b.name as nameParent');

        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<a class="editItem" href="'.route('organize.edit' , ['id' => $user->id]).'" title="Sửa"><i class="fa fa-fw fa-edit"></i></a>
                <a class="deleteItem" onclick=deleteOrganize("'.$user->id.'") title="Xóa"><i class="fa fa-fw fa-remove"></i></a>';
            })->make();
    }

    public function create(){
        $organize = new Organize();
        $data['listOrganization'] = Organize::select('id', 'name')->orderBy('name', 'ASC')->get();
        $data['organize'] = $organize;
        $data['buttons'] = [
            'backButton' => route('organize.index'),
            'saveButton' => true
        ];
        return view('backend.organize.create' , $data);
    }

    public function loadhtml(Request $request){
        $lang = !is_null(Loc::current()) ? Loc::current() : 'vi';
        $data = $request->all();
        $type = $data['level'];
        $code = Organize::select('code')->where('level' ,  $type)->orderBy('code' , 'desc')->first();
        $numberCode = 0;
        if(isset($code)){
            $numberCode = preg_replace("/[^0-9\.]/", '', $code->code);
        }
        $numberCode = $numberCode  + 1;
        $listCity = City::select('matp' , 'name')->get();
        switch ($type) {
            case 1:
                $data['listCity'] = $listCity;
                $viewData = view('backend.organize.includes.department_science_technology' ,  $data)->render();
                $name = __('label.organize.aliasName')." ".__('label.organize.organizing_scientific_and_technological_department');
                return response()->json(array('name' => $name , 'html'=>$viewData , 'numbercode' => 'DVQL'.$numberCode));
            case 2:
                $data['lstSupportType'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.support_type' , 'lang' =>  $lang])->get();
                $viewData = view('backend.organize.includes.startup_support_organization' ,  $data)->render();
                $name = __('label.organize.aliasName')." ".__('label.organize.support_organization');
                return response()->json(array('name' => $name , 'html'=>$viewData, 'numbercode' => 'TCHT'.$numberCode));
            case 3:
                $data['lstSupportTypeCG'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.support_type_cg' , 'lang' =>  $lang])->get();
                $viewData = view('backend.organize.includes.startup_support_professional' ,  $data)->render();
                $name = __('label.organize.aliasName')." ".__('label.organize.expert_support');
                return response()->json(array('name' => $name , 'html'=>$viewData, 'numbercode' => 'CG'.$numberCode));
            case 4:
                $data['lstInvestmentSector'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.investment_sector' , 'lang' =>  $lang])->get();
                $data['lstInvestmentPhase'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.investment_phase' , 'lang' =>  $lang])->get();
                $data['lstValue_of_investment'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.value_of_investment' , 'lang' =>  $lang])->get();
                $data['lstTypeInvestmentFunds'] = Dropdown::select('code' , 'name')
                    ->where(['type' => 'organization.support_organization.type_investment_funds' , 'lang' =>  $lang])->get();
                $viewData = view('backend.organize.includes.investment_funds' ,  $data)->render();
                $name = __('label.organize.aliasName')." ".__('label.organize.investment_funds');
                return response()->json(array('name' => $name , 'html'=>$viewData, 'numbercode' => 'TCDT'.$numberCode));
            case 5:
                $data['lstInvestmentSector'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.investment_sector' , 'lang' =>  $lang])->get();
                $data['lstDiploma'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.diploma' , 'lang' =>  $lang])->get();
                $data['lstSupportType'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.support_type' , 'lang' =>  $lang])->get();
                $data['listCity'] = $listCity;
                $viewData = view('backend.organize.includes.startup' ,  $data)->render();
                $name = __('label.organize.aliasName')." ".__('label.organize.startup');
                return response()->json(array('name' => $name , 'html'=>$viewData, 'numbercode' => 'DNST'.$numberCode));
            case 6:
                $data['lstInvestmentSector'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.investment_sector' , 'lang' =>  $lang])->get();
                $data['lstTypeInvestmentFunds'] = Dropdown::select('code' , 'name')
                    ->where(['type' => 'organization.support_organization.type_investment_funds' , 'lang' =>  $lang])->get();
                $viewData = view('backend.organize.includes.investors' ,  $data)->render();
                $name = __('label.organize.aliasName')." ".__('label.organize.investors');
                return response()->json(array('name' => $name , 'html'=>$viewData, 'numbercode' => 'NDT'.$numberCode));
        } 
    }

    public function store(Request $request){
        try{
            DB::beginTransaction();
            $data = $request->except('_token');
           
            if(isset($data['support_type'])){
                $data['support_type'] = join("," , $data['support_type']);
            }

            if(isset($data['needs_tobe_supported'])){
                $data['needs_tobe_supported'] = join("," , $data['needs_tobe_supported']);
            }

            if(isset($data['investment_sector'])){
                $data['investment_sector'] = join("," , $data['investment_sector']);
            }

            if(isset($data['properties'])){
                $data['properties'] = join("," , $data['properties']);
            }

            if(isset($data['business_areas'])){
                $data['business_areas'] = join("," , $data['business_areas']);
            }

            if(isset($data['belongto'])){
                $data['belongto'] = join("," , $data['belongto']);
            }

            $organize = new Organize($data);
            
            $organize->save();

            if(isset($data['legal_representative'])){
                foreach ($data['legal_representative'] as $item) {
                    $legalRepresentative = new LegalRepresentative($item);
                    $legalRepresentative->organize_id = $organize->id;
                    $legalRepresentative->save();
                }  
            }

            if(!is_null($request->file('certificate'))){

                $path = $request->file('certificate')->store(
                    'certificate/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );

                $organize->certificate = 'upload/'.$path;
                $organize->save();
            }
            DB::commit();
            \Session::flash('msg_organization', "Thêm mới thành công");
            return redirect()->route('organize.create');
        }catch(Exception $e){
            DB::rollBack();
            \Session::flash('msg_organization', "Có lỗi xảy ra xin vui lòng thử lại");
        }
    }

    public function edit($id){
        $organize = Organize::where('id' , $id)->first();
        $lang = !is_null(Loc::current()) ? Loc::current() : 'vi';
        if(is_null($organize)){
            return redirect()->route('organize.create'); 
        }
        $data['listOrganization'] = Organize::select('id', 'name')->orderBy('name', 'ASC')->get();
        $data['organize'] = $organize;
        $data['lstSupportType'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.support_type' , 'lang' =>  $lang])->get();
        $data['lstInvestmentSector'] = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.investment_sector' , 'lang' =>  $lang])->get();
        $data['lstInvestmentPhase'] = Dropdown::select('code' , 'name')
            ->where(['type' => 'organization.support_organization.investment_phase' , 'lang' =>  $lang])->get();
        $data['lstValue_of_investment'] = Dropdown::select('code' , 'name')
            ->where(['type' => 'organization.support_organization.value_of_investment' , 'lang' =>  $lang])->get();
        $data['lstTypeInvestmentFunds'] = Dropdown::select('code' , 'name')
            ->where(['type' => 'organization.support_organization.type_investment_funds' , 'lang' =>  $lang])->get();
        $data['lstDiploma'] = Dropdown::select('code' , 'name')
            ->where(['type' => 'organization.support_organization.diploma' , 'lang' =>  $lang])->get();
        $data['lstRepresentative'] = LegalRepresentative::where('organize_id' , $id)->get();
        $data['listCity'] = City::select('matp' , 'name')->get();
        $data['buttons'] = [
            'backButton' => route('organize.index'),
            'saveButton' => true
        ];
        return view('backend.organize.edit' , $data);  
    }

    public function update(Request $request){
        try{
            DB::beginTransaction();
            $data = $request->except(['_token', '_method' , 'legal_representative' , 'certificate']);
            $data_legal_representative =  $request->input(['legal_representative']);
            
            if(isset($data['support_type'])){
                $data['support_type'] = join("," , $data['support_type']);
            }

            if(isset($data['needs_tobe_supported'])){
                $data['needs_tobe_supported'] = join("," , $data['needs_tobe_supported']);
            }
            
            if(isset($data['investment_sector'])){
                $data['investment_sector'] = join("," , $data['investment_sector']);
            }
            
            if(isset($data['properties'])){
                $data['properties'] = join("," , $data['properties']);
            }

            if(isset($data['business_areas'])){
                $data['business_areas'] = join("," , $data['business_areas']);
            }

            if(isset($data['belongto'])){
                $data['belongto'] = join("," , $data['belongto']);
            }
            
            $dataInsert = [];
            foreach($data as $key => $value){
                if(!is_null($value) || $value != ""){
                    $dataInsert[$key] = $value;
                }
            }
            $organize = new Organize();
            $organizeNew = [];
            foreach($organize['fillable'] as $ite){
                $organizeNew[$ite] = null;
            }
            
            Organize::where('id' ,$dataInsert['id'])->update($organizeNew);

            Organize::where('id' ,$dataInsert['id'])->update($dataInsert);

            if(isset($data_legal_representative)){
                LegalRepresentative::where('organize_id' , $dataInsert['id'])->delete();
                foreach ($data_legal_representative as $item) {
                    $legalRepresentative = new LegalRepresentative($item);
                    $legalRepresentative->organize_id = $dataInsert['id'];
                    $legalRepresentative->save();
                }  
            }

            if(!is_null($request->file('certificate'))){
                $path = $request->file('certificate')->store(
                    'certificate/'.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );
                Organize::where('id' ,$dataInsert['id'])->update(['certificate' => 'upload/'.$path]);
            }
            DB::commit();
            \Session::flash('msg_organization', "Sửa thành công");
            return redirect()->route('organize.edit' , ['id'=> $request->id]);
        }catch(Exception $e){
            DB::rollBack();
            \Session::flash('msg_organization', "Có lỗi xảy ra xin vui lòng thử lại");
            return redirect()->route('organize.index');
        }
    }

    public function deleteOrganize($id) 
    {
        $ids = explode(",", $id);
        Organize::whereIn('id',$ids)->delete();
        \Session::flash('msg_organization', 'Xóa tổ chức thành công');
        return redirect()->route('organize.index');
    }

    public function addFounder(Request $request){
        $item = !is_null($request->input("item")) ? $request->input("item") : 0;
        if($item != 0){
            $lang = !is_null(Loc::current()) ? Loc::current() : 'vi';
            $lstDiploma = Dropdown::select('code' , 'name')
                ->where(['type' => 'organization.support_organization.diploma' , 'lang' =>  $lang])->get();
            return view('backend.organize.includes.legal_representative' , [
                'lstDiploma' => $lstDiploma,
                'item' => $item,
                'isAdd' => true
            ]);
        }
    }

    public function loadGroup(Request $request){
        $id = $request->input('id');
        if(isset($id)){
            return Group::where('organization_id' , $id)->select('id' , 'name' , 'organization_id')->get();
        }
    }

    public function import(Request $request){
        try{
            if($request->hasFile('files')){
                $path = $request->file('files')->getRealPath();
                $data0 = Excel::selectSheetsByIndex(0)->load($path)->get()->toArray();
                $this->common->saveDataOrganization1(1 , $data0);
                
                $data1 = Excel::selectSheetsByIndex(1)->load($path)->get()->toArray();
                $this->common->saveDataOrganization2(2 , $data1);
    
                $data2 = Excel::selectSheetsByIndex(2)->load($path)->get()->toArray();
                $this->common->saveDataOrganization3(3 , $data2);
    
                $data3 = Excel::selectSheetsByIndex(3)->load($path)->get()->toArray();
                $this->common->saveDataOrganization4(4 , $data3);
    
                $data4 = Excel::selectSheetsByIndex(4)->load($path)->get()->toArray();
                $this->common->saveDataOrganization5(5 , $data4);
    
                $data5 = Excel::selectSheetsByIndex(5)->load($path)->get()->toArray();
                $this->common->saveDataOrganization6(6 , $data5);            
            }
        }catch(Exception $e){
            return response()->json(array('status' => "error"));
        }
        return response()->json(array('status' => "success"));
    }

    public function downloadExcel(){
        return response()->download(public_path() . "/upload/orignization.xlsx");
    }
}
