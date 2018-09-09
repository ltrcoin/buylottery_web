<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Frontend\Game;
use App\Http\Models\Frontend\Ticket;
use App\Http\Models\Frontend\Winner;
use App\Http\Models\Frontend\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
	public function transaction() 
	{
		$pageSize = Ticket::PAGE_SIZE;
		$rs = Ticket::with('game')
					->where('user_id', Auth::guard('web')->user()->id)
					->orderBy('created_at', 'DESC')
					->paginate($pageSize);
		$data = [
			'list_data' => $rs
		];
		return view('frontend.account.transaction', $data);
	}

	public function win() {
		$pageSize = Winner::PAGE_SIZE;
		$rs = Winner::with(['game', 'prize'])
					->where('user_id', Auth::guard('web')->user()->id)
					->orderBy('created_at', 'ASC')
					->paginate($pageSize);
		$data = [
			'list_data' => $rs
		];
		return view('frontend.account.win', $data);
	}

	public function profile(Request $request) {
		if($request->isMethod('POST')) {
			/*validate data request*/
            Validator::make($request->all(), [
                'fullname' => 'required|max:255',
                'tel' => 'required|max:50',
                //'wallet_btc' => 'required|max:150',
                'country' => 'required',
                'address' => 'max:255'
            ])->validate();
            $customer = Customer::find(Auth::guard('web')->user()->id);
            $customer->fullname = $request->fullname;
            $customer->tel = $request->tel;
            //$customer->wallet_btc = $request->wallet_btc;
            $customer->dob = $request->dob;
            $customer->sex = $request->sex;
            $customer->country = $request->country;
            $customer->address = $request->address;
            /*upload file to public/upload/profile*/
            if ($request->hasFile('portraitimage')) {
                $path = $request->file('portraitimage')->store(
                    'profile/'.$request->email.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );
                $customer->portraitimage = 'upload/'.$path;
            }
            /*upload file to public/upload/profile*/
            if ($request->hasFile('passportimage')) {
                $path = $request->file('passportimage')->store(
                    'profile/'.$request->email.date("Y",time()).'/'.date("m",time()).'/'.date("d",time()), 'upload'
                );
                $customer->passportimage = 'upload/'.$path;
            }
            $customer->save();
            return redirect()->route('frontend.site.index');
		}
		$data = [
			'listGender' => Customer::$SEX,
        	'listCountry' => Customer::$COUNTRY
        ];
		return view('frontend.account.profile', $data);
	}
}
