<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Models\Backend\User;
use App\Http\Models\Backend\Organize;
use App\Http\Models\Backend\Dropdown;
use Yajra\DataTables\DataTables;
use DB;
use Carbon\Carbon;
use Loc;
class ReportController extends Controller
{
    /**
     * Display a listing of report
     *
     */
    public function index()
    {
        return view('backend.reports.index');
    }

    /**
     * Display report of startup count
     *
     */
    public function startup_count()
    {
        //Get startup count
        $dataReturn = [];$data = [];
        $rs_dropdown = Dropdown::select('code' , 'name')
        ->where(['type'=>'organization.support_organization.investment_sector' , 'lang' => 'vi'])
        ->get();
        foreach($rs_dropdown as $item){
            //$rs = DB::select("select `city` as city ,'".$item->name."' as name, COUNT(*) as count from tbl_organize where business_areas like '%".$item->code."%' and level = 5 group by city");
            $rs = Organize::select('city' , DB::raw("'".$item->name."' as name") , DB::raw("COUNT(*) as count"))
            ->where('business_areas' , 'like' , '%'.$item->code.'%')->where('level' , 5)
            ->groupBy("city")
            ->get()->toArray();
            $dataReturn = array_merge($dataReturn , $rs);
        }
        $dataSort = collect($dataReturn)->sortBy('city')->sortBy('name')->reverse()->toArray();

        $data['startup_count'] = $dataSort;
        return view('backend.reports.startup_count', $data);
    }

    public function maps(){
        $market = Organize::select('lat' , 'lng')
        ->whereNotNull('lat')->whereNotNull('lng')
        ->get();
        return view('backend.reports.maps' , compact('market'));
    }
}
