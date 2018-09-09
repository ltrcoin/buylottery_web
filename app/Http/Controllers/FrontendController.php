<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Models\Frontend\Menu;
use App\Http\Models\Frontend\Category;
use App\Http\Models\Frontend\News;
use App\Http\Models\Frontend\Product;
use App\Http\Models\Backend\AdsLink;
use App\Http\Models\Frontend\Setting;
use Config;

class FrontendController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    	                                                     
        //\View::share('dataShare', $data);
    }

    public function convertStr($str) 
    {
    // In thường
         $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
         $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
         $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
         $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
         $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
         $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
         $str = preg_replace("/(đ)/", 'd', $str);    
    // In đậm
         $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
         $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
         $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
         $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
         $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
         $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
         $str = preg_replace("/(Đ)/", 'D', $str);
         return $str; // Trả về chuỗi đã chuyển
    } 

    public function generateRatio($total) {
        $ratio = [];
        for($i=0;$i<$total; $i++) {
            $item[3] = rand(2, 3)/100;
            $item[0] = rand(18, 25)/100;
            $item[2] = round($item[0]*0.6, 2);
            $item[1] = 1 - ($item[0]+$item[2]+$item[3]);
            $ratio[$i] = $item;
        }
        return $ratio;
    }

    public function fakeResult($total_sv, $total_question) {
        $tyle = $this->generateRatio($total_question);
        $ch = 0;
        $rs = [];
        foreach ($tyle as $key => $ratio) {
            $t = 0;
            for($i=0;$i<3;$i++) {
                $x[$i] = round($total_sv*$ratio[$i]);
                $t += $x[$i];
            }
            $x[3] = $total_sv-$t;
            $rs[$key] = $x;
        }
        return $rs;
    }

}
