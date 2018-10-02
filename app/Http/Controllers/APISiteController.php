<?php

namespace App\Http\Controllers;

use App\Http\Models\Frontend\Game;
use App\Http\Models\Frontend\Ticket;
use App\Http\Controllers\Frontend\GameController;
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
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
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
    
    public function getbalance(Request $request)
    {
       $useremail=request('email');
       $userpassword=request('password');
       $apikey=$request->apikey;  
       $envapi=env('ONESIGNAL_API_KEY');   
       if ( strcasecmp( $apikey, $envapi ) == 1 ){
         return response()->json([
                                    'status'=>422,
                                    'msg'=>'Invalid API Key ..',
                                    'data'=>''
                                    ]);
        }
		$credentials = [
                'email' => $useremail, 
            ];
             
        $customer = Customer::where($credentials)->first();
         if (!isset(($customer))) { 
            return response()->json([
                                    'status'=>401,
                                    'msg'=>'Wrong email',
                                    'data'=>''
                                    ]);

        }
        if(\Hash::check($userpassword, $customer->password)) 
        {

          
         //---------- call Hung API sign in de get Token chung ..

          $ltr2='http://35.185.180.127:3000/api/signin';

          $client2 = new Client([
            
             'base_uri' => $ltr2,               
             'timeout'  => 9.0,
             'form_params' => [
                'email'=>$customer->email,
                'password'=>$customer->password            
                ]
            ]);

        try {
		   $response2=$client2->request('POST');
		  
		} 
		
		 catch (ClientException $e) {
		    return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ClientException',
                                        'data'=>''
                                        ]);
		}
   		catch (RequestException $e) {
		     return response()->json([
                                        'status'=>422,
                                        'msg'=>'API RequestException',
                                        'data'=>''
                                        ]);
		}
   		catch (ConnectException $e) {
		    return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ConnectException',
                                        'data'=>''
                                        ]);
		}
		
          $body2 = $response2->getBody(true);
          $json2 = json_decode($body2, true);      
          $token='JWT '.$json2['token'];
          // Luu token vao dau? Vao database remember token..
          //--------------hoặc 
          $ltr3='http://35.185.180.127:3000/api/getInfoWallet';

          $client3 = new Client([
            
             'base_uri' => $ltr3,               
             'timeout'  => 9.0,
             'headers' => [
                'Authorization'=>$token                          
                ]
            ]);

		try {
		   $response3 = $client3->request('GET');  
		}
		 catch (ClientException $e) {
		    return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ClientException 2',
                                        'data'=>''
                                        ]);
		}
   		catch (RequestException $e) {
		     return response()->json([
                                        'status'=>422,
                                        'msg'=>'API RequestException 2',
                                        'data'=>''
                                        ]);
		}
   		catch (ConnectException $e) {
		    return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ConnectException 2',
                                        'data'=>''
                                        ]);
		}
		
                  
          $body3 = $response3->getBody();
          
          $json3 = json_decode($body3, true);          
              
       
        
             // return token cho APP.  cas API deu can dung 2 key, API key + Token

                return response()->json([
                                            'status'=>200,
                                            'msg'=>'Successfully get balance',
                                            'data'=>$json3
                                            ]);
                
            } else {
                return response()->json([
                                        'status'=>401,
                                        'msg'=>'Wrong password',
                                        'data'=>''
                                        ]);
            }
          
    	}
     


    public function buytickets(Request $request)
    {
     
     // Toan bo phan check ETH Balance, LTR balance la do APP thuc hien.
     // Khi da check ok thi moi chuyen den buytickets API.
     // data raw  
	   
    $ticketsraw = json_decode(request()->getContent(), true);

    $useremail=$ticketsraw[0]['email'];
    $userpassword=$ticketsraw[0]['password'];
    $apikey=$ticketsraw[0]['apikey'];

	$envapi=env('ONESIGNAL_API_KEY');   
       if ( strcasecmp( $apikey, $envapi ) == 1 ){
         return response()->json([
                                    'status'=>402,
                                    'msg'=>'Invalid API Key ..',
                                    'data'=>''
                                    ]);
        }
		$credentials = [
                'email' => $useremail, 
            ];
             
        $customer = Customer::where($credentials)->first();
         if (!isset(($customer))) { 
            return response()->json([
                                    'status'=>401,
                                    'msg'=>'Wrong email',
                                    'data'=>''
                                    ]);

        }
    if(\Hash::check($userpassword, $customer->password)) 
        { 
         //---------- call Hung API sign in de get Token chung ..

          $ltr2='http://35.185.180.127:3000/api/signin';

          $client2 = new Client([
            
             'base_uri' => $ltr2,               
             'timeout'  => 9.0,
             'form_params' => [
                'email'=>$customer->email,
                'password'=>$customer->password            
                ]
            ]);

        try {
		   $response2=$client2->request('POST');
		  
		} 
		
		 catch (ClientException $e) {
		    return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ClientException 1',
                                        'data'=>''
                                        ]);
		}
   		catch (RequestException $e) {
		     return response()->json([
                                        'status'=>422,
                                        'msg'=>'API RequestException 1',
                                        'data'=>''
                                        ]);
		}
   		catch (ConnectException $e) {
		    return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ConnectException 1',
                                        'data'=>''
                                        ]);
		}
		
          $body2 = $response2->getBody(true);
          $json2 = json_decode($body2, true);      
          $token='JWT '.$json2['token'];

          $tickets=[];
        		for ($i = 1; $i < count($ticketsraw); $i++) {
			     
			  $tickets[]=$ticketsraw[$i];
			}

    	 	
		$typePrizeID=GameController::transFormGameIDToString($tickets);
        $valueUSD=0.05; //$totalCost*$currenLTRUSDrate; 
        $message=GameController::transFormTicketsToString($tickets);
        $buyFrom='app';
  
		$ltr5='http://35.185.180.127:3000/api/BuyLotter';

          $client5 = new Client([
            
             'base_uri' => $ltr5,               
             'timeout'  => 9.0,
             'headers' =>[ 
   				'Authorization'=>$token
           	 ],
             'form_params' => [
                'typePrizeID'=>$typePrizeID,
                'valueUSD'=>$valueUSD,
                'message'=>$message,
                'buyFrom'=>$buyFrom          
                ]
            ]
             
        );

		try {
		     $response5 = $client5->request('POST');
		}
		catch (RequestException $e) {
			return response()->json([
                                        'status'=>422,
                                        'msg'=>'API RequestException 2',
                                        'data'=>''
                                        ]);
		}

		 catch (ClientException $e) {
		 	 return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ClientException 2',
                                        'data'=>''
                                        ]);
		}
		 catch (ConnectException $e) {
		 	return response()->json([
                                        'status'=>422,
                                        'msg'=>'API ConnectException 2',
                                        'data'=>''
                                        ]);
		}

          $body5 = $response5->getBody();
           
          $receipt = json_decode($body5, true);
          // insert txhash to tickets and save to database

         $ticketsToSave = [];
    
            foreach ( $tickets as $ticket ) {
               
                    $ticketsToSave[] = [
                        'game_id'         => $ticket['game_id'],
                        'user_id'         => $ticket['user_id'],
                        'numbers'         => $ticket['numbers'],
                        'special_numbers' => $ticket['special_numbers'] ?? null,
                        'price'           => $ticket['price'],
                        'status'          => $ticket['status'],
                        'created_at'      => Carbon::now(),
                        'txhash'          => $receipt['TxHash']
                    ];

                }

         Ticket::insert( $ticketsToSave);

          // save tickets
          return response()->json([
                                        'status'=>200,
                                        'msg'=>'Buy tickets successfully',
                                        'data'=>$receipt
                                        ]);

                    
        } else {
                return response()->json([
                                        'status'=>401,
                                        'msg'=>'Wrong password',
                                        'data'=>''
                                        ]);
            }
       
    }
    
    

    public function gamesinfo()
    {
       
    $list_game = Game::all();

    return response()->json($list_game);
    }

     public function winningnumbersapi()
    {
       
    $list_winning_numbers = WinningNumber::all();

    return response()->json($list_winning_numbers);
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
       $apikey=$request->apikey;  
       $envapi=env('ONESIGNAL_API_KEY');   
        if ( strcasecmp( $apikey, $envapi ) == 1 ){
         return response()->json([
                                    'status'=>422,
                                    'msg'=>'Invalid API Key ..',
                                    'data'=>''
                                    ]);
        }
       
       $credentials = [
                'email' => $useremail, 
                'status' => Customer::STATUS_ACTIVE
            ];
        $customer = Customer::where($credentials)->first();
         if (!isset(($customer))) { 
            return response()->json([
                                    'status'=>401,
                                    'msg'=>'Wrong email',
                                    'data'=>''
                                    ]);

        }

        if(\Hash::check($userpassword, $customer->password)) 
        {
        
                    $customer->pkey='protected';
                    $customer->password='protected';
                    $customer->remember_token='protected';
                    // call Hung API sign in de get Token chung ..
                    // return token cho APP.  cas API deu can dung 2 key, API key + Token

                    return response()->json([
                                            'status'=>200,
                                            'msg'=>'Login successfull',
                                            'data'=>$customer
                                            ]);
                
            } else {
                return response()->json([
                                        'status'=>401,
                                        'msg'=>'Wrong password',
                                        'data'=>''
                                        ]);
            }
          
    }

//--- end of api login

//------------------api ValidateRegister
  
 public function validateregister(Request $request) 
    {
       
       $apikey=$request->apikey;  
       $envapi=env('ONESIGNAL_API_KEY');   
        if ( strcasecmp( $apikey, $envapi ) == 1 ){
         return response()->json([  'status'=>422,
                                    'msg'=>'Invalid API Key',
                                    'data'=>''
                                    ]);
        }

        

    //-----Validate data------
        $validator = Validator::make($request->all(), [
            //'fullname' => 'required|max:255',
            'email' => 'required|email|unique:customers|max:255',
            
            //'wallet_btc' => 'required|unique:customers|max:150',
            //'country' => 'required',
            //'address' => 'max:255',
            /*'portraitimage' => 'required',
            'passportimage' => 'required',*/
            'password' => 'required|max:255',
            'tel' => 'required|unique:customers|max:50'
            //'re_password' => 'required|max:255|same:password'
        ])->setAttributeNames([
            //'fullname' => 'Full Name',
            'email' => 'email',
            
            //'wallet_btc' => 'Wallet BTC',
            //'country' => 'Country',
            //'address' => 'Address',
            /*'portraitimage' => 'Portrait image',
            'passportimage' => 'Passport image',*/
            'password' => 'password',
            'tel' => 'tel'
            //'re_password' => 'Confirm password'
        ]);
    if ($validator->fails()) {
    	$errors = $validator->errors();
        return response()->json([ 'status'=>422,
                                    'msg'=>[
                                    		'email'=>$errors->first('email'),
                                    		'password'=>$errors->first('password'),
                                    		'tel'=>$errors->first('tel')
                                    	],
                                    'data'=>''
                                    ]);
                            
        }
      

       return response()->json([
                               'status'=>200,
                               'msg'=>'Validation pass',
                               'data'=>''
                               ]);
           
          
    }

//--- end of api ValidateRegister


//------------------api Register
  
 public function apiregister(Request $request) 
    {
       $apikey=$request->apikey;  
       $envapi=env('ONESIGNAL_API_KEY');   
        if ( strcasecmp( $apikey, $envapi ) == 1 ){
         return response()->json([
                                    'status'=>422,
                                    'msg'=>'Invalid API Key ..',
                                    'data'=>''
                                    ]);
        }
       
//-----Validate data------
        $validator = Validator::make($request->all(), [
            //'fullname' => 'required|max:255',
            'email' => 'required|email|unique:customers|max:255',
            
            //'wallet_btc' => 'required|unique:customers|max:150',
            //'country' => 'required',
            //'address' => 'max:255',
            /*'portraitimage' => 'required',
            'passportimage' => 'required',*/
            'password' => 'required|max:255',
            'tel' => 'required|unique:customers|max:50'
            //'re_password' => 'required|max:255|same:password'
        ])->setAttributeNames([
            //'fullname' => 'Full Name',
            'email' => 'email',
            
            //'wallet_btc' => 'Wallet BTC',
            //'country' => 'Country',
            //'address' => 'Address',
            /*'portraitimage' => 'Portrait image',
            'passportimage' => 'Passport image',*/
            'password' => 'password',
            'tel' => 'tel'
            //'re_password' => 'Confirm password'
        ]);
        if ($validator->fails()) {
        return response()->json([
                                    'status'=>422,
                                    'msg'=>$validator->errors(),
                                    'data'=>''
                                    ]);

        }
        //---------

      $customer = new Customer();
      
      $customer->email = $request->email;
      $customer->password = bcrypt($request->password);
      
       
            $customer->fullname = $request->fullname;
            
            $customer->tel = $request->tel;
            $customer->wallet_btc=$request->wallet_btc;
            $customer->wallet_ltr=SiteController::ltraddress($customer->email, $customer->password);
        
            //$customer->wallet_ltr='test upload';
            
           
            $customer->dob = Carbon::parse($request->dob)->format('Y-m-d');

            $customer->sex = intval($request->sex);
            $customer->country =intval($request->country);
            $customer->address = $request->address;
            $customer->status = Customer::STATUS_ACTIVE;

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

       return response()->json([
                               'status'=>200,
                               'msg'=>'Register succesfully',
                               'data'=>[
                                'wallet_ltr'=>$customer->wallet_ltr
                                    ]
                               ]);
           
          
    }

//--- end of api Register

    public function validateAjax(Request $request) {
        $validator = Validator::make($request->all(), [
            //'fullname' => 'required|max:255',
            'email' => 'required|email|unique:customers|max:255',
            //'tel' => 'required|unique:customers|max:50',
            //'wallet_btc' => 'required|unique:customers|max:150',
            //'country' => 'required',
            //'address' => 'max:255',
            /*'portraitimage' => 'required',
            'passportimage' => 'required',*/
            'password' => 'required|max:255',
            //'re_password' => 'required|max:255|same:password'
        ])->setAttributeNames([
            //'fullname' => 'Full Name',
            'email' => 'Email',
            //'tel' => 'Phone',
            //'wallet_btc' => 'Wallet BTC',
            //'country' => 'Country',
            //'address' => 'Address',
            /*'portraitimage' => 'Portrait image',
            'passportimage' => 'Passport image',*/
            'password' => 'Password',
            //'re_password' => 'Confirm password'
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
        return $response;
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
