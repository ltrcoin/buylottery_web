<?php

namespace App\Http\Controllers;

use App\Http\Models\Frontend\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Frontend\Customer;
use App\Http\Models\Frontend\WinningNumber;
use App\Http\Models\Frontend\Winner;
use App\Http\Models\Frontend\Prize;
use GuzzleHttp\Client;
use App\Http\Controllers\Frontend\SiteController;
use Illuminate\Support\Facades\Storage;

class APISiteController extends Controller
{
    protected $client;
    protected $api_key;
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://www.magayo.com/api/']);
        $this->api_key  = env('KEY_API_MAGAYO', 'BihxeWYc7XqbTjw6wA');
    }

    public function index()
    {
    	// get all game
        $list_game = Game::all();

        // get winning number
        $winnings = [];
        $games = [];
        foreach ($list_game as $game) {
            // add prize to game item
            $prize = Prize::select(\DB::raw('max(value) as prize, unit'))
                        ->where('game_id', $game->id)
                        ->groupBy('value', 'unit')
                        ->first();
            array_push($games, [
                'game' => $game,
                'prize' => $prize
            ]);

            // get winning number
            $winning_number = WinningNumber::select('winning_numbers.*', 'games.image', 'games.name', 'games.alias')
                                            ->join('games', 'games.id','=','winning_numbers.game_id')
                                            ->where('winning_numbers.game_id', $game->id)
                                            ->take(5)
                                            ->orderBy('winning_numbers.draw_date', 'DESC')
                                            ->get();
            if(count($winning_number) > 0) {
                array_push($winnings, $winning_number);
            }
        }

        // get winner
        $winners = Winner::with(['customer', 'game', 'ticket', 'prize', 'winningnumber'])
                        ->take(8)
                        ->orderBy('user_id')
                        ->get();
        $data = [
            'games' => $games,
            'winners' => $winners,
            'winnings' => $winnings
        ];

    	return view("frontend.site.index", $data);
    }

    public function login(Request $request) 
    {
        if($request->isMethod("post")) {            
            /*validate data request*/
            Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|max:255'
            ])->validate();
            $credentials = [
                'email' => $request->email, 
                'status' => Customer::STATUS_ACTIVE
            ];
            $remember_token = ($request->remember_token != null) ? true : false;
            $customer = Customer::where($credentials)->firstOrFail();



            if(\Hash::check($request->password, $customer->password)) {
                \Session::put('2fa:isLogged', $customer);
                if(!isset($customer->passwordSecurity) || !$customer->passwordSecurity->google2fa_enable) {
                    return redirect()->route('frontend.ps.show2faForm');
                } else {
                    return redirect()->route('frontend.ps.verify2fa');
                }
            } else {
                return redirect()->route('frontend.site.vLogin')->withErrors("Email or password incorrect!");
            }
        }
        \Session::forget('2fa:isLogged');
        return view('frontend.site.login');
    }

//------------------api login 
 public function apilogin(Request $request) 
    {
        
       $useremail=request('email');
       $userpassword=request('password');
       $apikey=request('apikey');    
       
       if (!($apikey== env('ONESIGNAL_API_KEY'))) {
            return response()->json([
                                    'status'=>422,
                                    'msg'=>'Invalid API Key',
                                    'data'=>[]
                                    ]);
        };
       
       $credentials = [
                'email' => $useremail, 
                'status' => Customer::STATUS_ACTIVE
            ];
        $customer = Customer::where($credentials)->first();
         if (!isset(($customer))) { 
            return response()->json([
                                    'status'=>401,
                                    'msg'=>'Wrong email',
                                    'data'=>[]
                                    ]);

        }

        if(\Hash::check($userpassword, $customer->password)) 
        {
                \Session::put('2fa:isLogged', $customer);
                if(!isset($customer->passwordSecurity) || !$customer->passwordSecurity->google2fa_enable) {
                    return redirect()->route('frontend.ps.show2faForm');
                } else {
                   
                    return response()->json([
                                            'status'=>200,
                                            'msg'=>'Login successfull',
                                            'data'=>$customer
                                            ]);
                }
            } else {
                return response()->json([
                                        'status'=>401,
                                        'msg'=>'Wrong password',
                                        'data'=>[]
                                        ]);
            }
          
    }

//--- end of api login

//------------------api Register
  
 public function apiregister(Request $request) 
    {
        $customer = new Customer();

        $customer->fullname = $request->email;
        $customer->email = $request->password;

       $apikey=$request->apikey;    
       
       if (!($apikey== env('ONESIGNAL_API_KEY'))) {
            return response()->json([
                                    'status'=>422,
                                    'msg'=>'Invalid API Key',
                                    'data'=>[]
                                    ]);
        }; 

   

            $customer->fullname = $request->fullname;
            $customer->email = $request->email;
            $customer->password = bcrypt($request->password);
            $customer->tel = $request->tel;
            $customer->wallet_btc=$request->wallet_btc;
            //$customer->wallet_ltr=SiteController::ltraddress($customer->email, $customer->password);
        
            $customer->wallet_ltr='test upload $requets';
            
           
            $customer->dob = Carbon::parse($request->dob)->format('Y-m-d');

            $customer->sex = intval($request->sex);
            $customer->country =intval($request->country);
            $customer->address = $request->address;
            $customer->status = Customer::STATUS_ACTIVE;

    
       $customer->save();


     
       return response()->json([
                               'status'=>200,
                               'msg'=>'Register successfully',
                               'data'=>[
				   'wallet_ltr'=>$customer->wallet_ltr
]
                               ]);
           
          
    }

//--- end of api Register




    public function validateAjax(Request $request) {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|max:255',
            'email' => 'required|email|unique:customers|max:255',
            'tel' => 'required|unique:customers|max:50',
            'wallet_btc' => 'required|unique:customers|max:150',
            'country' => 'required',
            'address' => 'max:255',
            /*'portraitimage' => 'required',
            'passportimage' => 'required',*/
            'password' => 'required|max:255',
            're_password' => 'required|max:255|same:password'
        ])->setAttributeNames([
            'fullname' => 'Full Name',
            'email' => 'Email',
            'tel' => 'Phone',
            'wallet_btc' => 'Wallet BTC',
            'country' => 'Country',
            'address' => 'Address',
            /*'portraitimage' => 'Portrait image',
            'passportimage' => 'Passport image',*/
            'password' => 'Password',
            're_password' => 'Confirm password'
        ]);
        if ($validator->fails()) {
            $response = [
                'error' => true,
                'data' => $validator->errors()
            ];
        } else {
            $response = [
                'error' => false,
                'data' => ''
            ];
        }
        return response()->json($response);
    }

    public function error()
    {
        return view('frontend.site.error');
    }

    public function logout()
    {
        \Session::flush();
        Auth::guard('web')->logout();
        return redirect()->route('frontend.site.index');
    }
}
