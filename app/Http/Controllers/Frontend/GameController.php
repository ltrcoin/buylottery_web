<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Number;
use App\Http\Models\Frontend\Game;
use App\Http\Models\Frontend\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;


class GameController extends Controller
{
	private $temptoken = '123';

	public function play( $alias )
	{
		$game              = Game::where( 'alias', $alias )->first();
		$data['game']      = $game;
		$data['pageTitle'] = __( 'label.game.buy_ticket' );
		$data['gameInfo']  = json_encode( $game->toArray() );

		return view( 'frontend.game.play', $data );
	}

	public function submitTicket( Request $request )
	{
		$data    = $request->all();
		$game    = Game::find( $request->game_id );
		$tickets = [];
		foreach ( $data['normal'] as $index => $normal ) {
			if (!($normal==null)) {

				$ticket = ['normal' => $normal];
				if ( ! empty( $data['special'] ) && ! empty( $data['special'][ $index ] ) ) {
					$ticket['special'] = $data['special'][ $index ];
				}
				$tickets[] = $ticket;
			}
		}

		$cart = session( '_cart' ) ?? [];
		if ( ! count( $cart ) ) {
			$cart[ $data['game_id'] ] = [
				'game'    => $game,
				'tickets' => $tickets,
				'cost'    => count( $tickets ) * ( $game->ticket_price )
			];
		} else if ( empty( $cart[ $data['game_id'] ] ) ) {
			$cart[ $data['game_id'] ] = [
				'game'    => $game,
				'tickets' => $tickets,
				'cost'    => count( $tickets ) * ( $game->ticket_price )
			];
		} else {
			$existedTickets = $cart[ $data['game_id'] ]['tickets'];
			foreach ( $tickets as $ticket ) {
				if ( ! Number::checkExistedTicket( $existedTickets, $ticket ) ) {
					$existedTickets[] = $ticket;
				}
			}
			$cart[ $data['game_id'] ] = [
				'game'    => $game,
				'tickets' => $existedTickets,
				'cost'    => count( $existedTickets ) * ( $game->ticket_price )
			];
		}
		session( [
			'_cart' => $cart
		] );

		return redirect()->route( 'frontend.game.cart' );
	}

	public function cart()
	{
		$games     = session( '_cart' );
		$totalCost = 0;

		if ( ! empty( $games ) ) {
			foreach ( $games as $game ) {
				$totalCost += $game['cost'];
			}
		}
		//print_r($games);
		return view( 'frontend.game.cart', compact( 'games', 'totalCost' ) );
	}
//----------etherscan api
public static function g_account_balance(Request $request, $address) 
    {        
     $ltr='https://api.etherscan.io/api?module=account&action=balance&address='.$address;

          $client2 = new Client([
            
             'base_uri' => $ltr,               
             'timeout'  => 6.0,
             
            ]);         
		   $response2=$client2->request('GET');                 
          $body2 = $response2->getBody();
          $json2 = json_decode($body2, true);          
              
        return $json2;
        
    }

//------------end G --AccountBalance function

public static function g_ltr_account_balance(Request $request, $contractaddress, $address) 
    {       

     $ltr='https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress='.$contractaddress.'&address='.$address;

          $client2 = new Client([
            
             'base_uri' => $ltr,               
             'timeout'  => 6.0,
             
            ]);

         
		  $response2=$client2->request('GET');                
          $body2 = $response2->getBody();          
          $json2 = json_decode($body2, true);          
              
        return $json2;
        
    }


//-----Return Account Balance LTR, ETH  
//     Return '-1' or '-2' if error

public static function account_balance(Request $request, $email, $password) 
    {       
          
        $error1=['ETHBalance'=>-1, 'LTRBalance'=>'ClientException. Try again later'];
        $error2=['ETHBalance'=>-2, 'LTRBalance'=>'RequestException. Try again later'];
        $error3=['ETHBalance'=>-3, 'LTRBalance'=>'ConnectException. Try again later'];
        $error4=['ETHBalance'=>-4, 'LTRBalance'=>'GetInfoException. Try again later'];
          // -- sign in to get Token

        $ltr2='http://35.185.180.127:3000/api/signin';

          $client2 = new Client([
            
             'base_uri' => $ltr2,               
             'timeout'  => 3.0,
             'form_params' => [
                'email'=>$email,
                'password'=>$password            
                ]
            ]);

        try {
		   $response2=$client2->request('POST');
		   // RequestException ? chua handle
		} 
		

		 catch (ClientException $e) {
		    return $error1;
		}
   		catch (RequestException $e) {
		    return $error2;
		}
   		catch (ConnectException $e) {
		    return $error3;
		}
		
          $body2 = $response2->getBody(true);
          error_log($body2);
          $json2 = json_decode($body2, true);
         
          $token='JWT '.$json2['token'];
          $request->session()->put('token',$token);

          error_log('Token la: '.$token);

          $ltr3='http://35.185.180.127:3000/api/getInfoWallet';

          $client3 = new Client([
            
             'base_uri' => $ltr3,               
             'timeout'  => 3.0,
             'headers' => [
                'Authorization'=>$token                          
                ]
            ]);

		try {
		   $response3 = $client3->request('GET');  
		} catch (ClientException $e) {
		    return $error4;
		}
                  
          $body3 = $response3->getBody();
          error_log($body3);
          $json3 = json_decode($body3, true);          
              
        return $json3;
        
    }

//------------end AccountBalance function


// ----Buylottery function

public function buyNow(Request $request, $typePrizeID, $valueUSD ,$message ,$buyFrom) 
    {       

          $ltr5='http://35.185.180.127:3000/api/BuyLotter';

          $client5 = new Client([
            
             'base_uri' => $ltr5,               
             'timeout'  => 9.0,
             'headers' =>[ 
   				'Authorization'=>$request->session()->get('token')
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
			$erReceipt=[
		 		"TxHash"=>'Try again later. RequestException at '.Carbon::now(),
		 		'LTRValue'=>0
		 	]; 
		    return $erReceipt;
		}

		 catch (ClientException $e) {
		 	$erReceipt=[
		 		"TxHash"=>'Try again later. ClientException at '.Carbon::now(),
		 		'LTRValue'=>0
		 	]; 
		 	return $erReceipt;
		}
		 catch (ConnectException $e) {
		 	$erReceipt=[
		 		"TxHash"=>'Try again later. ConnectException at '.Carbon::now(),
		 		'LTRValue'=>0
		 	]; 
		 	return $erReceipt;
		}

          $body5 = $response5->getBody();
           
          $json5 = json_decode($body5, true);          
              
        return $json5;
        
    }



public function buyMultiNow(Request $request, $data) 
    {       

         $ltr5='http://35.185.180.127:3000/api/BuyMultiGameLotter';
 
         

          $client5 = new Client([
            
             'base_uri' => $ltr5,               
             'timeout'  => 9.0,
             'headers' =>[
             	'Content-Type' => 'application/json',
   				'Authorization'=>$request->session()->get('token')
           	 			],
             'body' => json_encode($data)       
            ]
             
        );

          		     $response5 = $client5->request('POST');
/*
		try {
		     $response5 = $client5->request('POST');
		}
		catch (RequestException $e) {
			$erReceipt=[
		 		"TxHash"=>'Try again later. RequestException at '.Carbon::now(),
		 		'LTRValue'=>0
		 	]; 
		    return $erReceipt;
		}

		 catch (ClientException $e) {
		 	$erReceipt=[
		 		"TxHash"=>'Try again later. ClientException at '.Carbon::now(),
		 		'LTRValue'=>0
		 	]; 
		 	return $erReceipt;
		}
		 catch (ConnectException $e) {
		 	$erReceipt=[
		 		"TxHash"=>'Try again later. ConnectException at '.Carbon::now(),
		 		'LTRValue'=>0
		 	]; 
		 	return $erReceipt;
		}
*/
          $body5 = $response5->getBody();
           
          $json5 = json_decode($body5, true);          
              
        return $json5;
        
    }

//------------end BuyLotter function

	public function checkout(Request $request)
	{
		$games     = session( '_cart' );
		$totalCost = 0;
		$balance=$this->account_balance($request, Auth::guard('web')->user()->email, 
												  Auth::guard('web')->user()->password);

		$eth_balance=$balance['ETHBalance'];
		$ltr_balance=$balance['LTRBalance'];


		error_log('password hash la'.Auth::guard('web')->user()->password);

		foreach ( $games as $game ) {
			$totalCost += $game['cost'];
		}
		if ($eth_balance < 0) {
			return view( 'frontend.game.blockchain_error',['error'=>$ltr_balance]);
		}
		return view( 'frontend.game.checkout', 
			compact( 'games', 'totalCost','ltr_balance','eth_balance' ));
	}

	//-----------Begin of transFormGameIDToString Function
	//-----------Used for API Call to Buy Ticket in LTR

public static function transFormGameIDToString($tickets) {

switch ($tickets['0']['game_id']) {
 	case 1:
 		return 'Europe_EuroJackpot';
 		break; 	
 	case 2:
 		return 'U.S_MegaMillions';
 		break;
 	case 3:
 		return 'VN_LTRJackpot';
 		break;
 }

}

	//-----------Used for API Call to Buy Ticket in LTR
public static function transFormMultiTicketToString($tickets) {

$ticketslen=count($tickets);
		
$ticketsstring='';
for($i=0; $i<$ticketslen; $i++) 
	{
		
			$num = $tickets[$i]['numbers'];
			$newnum=explode(" ",$num);
			$numlength = count($newnum);

			for($x = 0; $x < $numlength; $x++) {
			    
			    if ($newnum[$x] < 10) {
			    	$addzero1= sprintf("%02d", $newnum[$x]);
			    	$newnum[$x]=$addzero1;
			    }
			    
			}

			$newnumstr=implode("",$newnum);
			$tempstr=$newnumstr;
			switch ($tickets['0']['game_id']) {
			 	case 1:
			 		$newnumstr='EE'.$tempstr;
			 		break; 		
			 	case 2:
			 		$newnumstr='UM'.$tempstr;
			 		break;
			 	case 3:
			 		$newnumstr='VL'.$tempstr;
			 		break;
			 }
			
			$newspestr='';
			if ($tickets[$i]['special_numbers']) {

					$spe = $tickets[$i]['special_numbers'];
					$newspe=explode(" ",$spe);
					$spelength = count($newspe);
					 
					for($y = 0; $y < $spelength; $y++) {
					    
					    if ($newspe[$y] < 10) {
					    	$addzero2= sprintf("%02d", $newspe[$y]);
					    	$newspe[$y]=$addzero2;
					    }
					    
					}

					$newspestr= implode("",$newspe);
				}

			$newnumspestr=$newnumstr.$newspestr;


			
			 $ticketsstring=$ticketsstring.$newnumspestr."-";

			
	}
		$finalticketsstring=chop($ticketsstring,"-");
	 
	return $finalticketsstring;

	}

public static function transFormTicketsToString($ticket) {
	
$ticketslen=count($tickets);
		
$ticketsstring='';
for($i=0; $i<$ticketslen; $i++) 
	{
		
			$num = $tickets[$i]['numbers'];
			$newnum=explode(" ",$num);
			$numlength = count($newnum);

			for($x = 0; $x < $numlength; $x++) {
			    
			    if ($newnum[$x] < 10) {
			    	$addzero1= sprintf("%02d", $newnum[$x]);
			    	$newnum[$x]=$addzero1;
			    }
			    
			}

			$newnumstr=implode("",$newnum);
			
			$newspestr='';
			if ($tickets[$i]['special_numbers']) {

					$spe = $tickets[$i]['special_numbers'];
					$newspe=explode(" ",$spe);
					$spelength = count($newspe);
					 
					for($y = 0; $y < $spelength; $y++) {
					    
					    if ($newspe[$y] < 10) {
					    	$addzero2= sprintf("%02d", $newspe[$y]);
					    	$newspe[$y]=$addzero2;
					    }
					    
					}

					$newspestr= implode("",$newspe);
				}

			$newnumspestr=$newnumstr.$newspestr;

			$ticketsstring=$ticketsstring.$newnumspestr."-";	
	}
	$finalticketsstring=chop($ticketsstring,"-");
	 
	return $finalticketsstring;

}


public function transFormMultiTickets($tickets) {
	$multiTickets=[
		'typePrizeID'=>[],
  		'valueUSD'=>[],
  		'message'=>[],
  		'buyFrom'=>'buylottery',
	];

	foreach ($tickets as $ticket) {

		switch ($ticket['game_id']) {
		 	case 1:
		 		$multiTickets['typePrizeID'][]='Europe_EuroJackpot';
		 		break; 	
		 	case 2:
		 		$multiTickets['typePrizeID'][]='U.S_MegaMillions';
		 		break;
		 	case 3:
		 		$multiTickets['typePrizeID'][]='VN_LTRJackpot';
		 		break;
		 }

		 $multiTickets['valueUSD'][]=0.1;
		 $multiTickets['message'][]=$this->transFormMultiTicketToString($ticket);
	 
	}


	return $multiTickets;
}

public function buyltr(Request $request) 
    {       
    	// Buy LTR se co 2 viec, 1

    	// la chuyen ETH trong vi  hien tai dang login cua khach sang vi ETH cua Lottery
    	// Sau khi vi ETH cua Lottery nhan duoc so ETH can thiet, vi Lotter se chuyen LTR 
    	// vao vi cua khach. Hien tai lam truoc buoc 2, la chuyen tu vi Lottery (ansangGmailcom) sang vi cua khach (vi nodeeth gmailcom)
         
    	$mainAccountEmail='ansang@gmail.com';
    	$mainAccountPassword='$2y$10$5woBPaOBG1KuqYPzVtxWiOVIVxekDA12ZTPRWHL5yvnBZVHPSJOA.';
    	$mainAccountAddress='0x0530977c34b1623Dc4D4557F1E2ED94Ea6EAF5aD';

        $error1=['error'=>'ClientException. Try again later'];
        $error2=['error'=>'RequestException. Try again later'];
        $error3=['error'=>'ConnectException. Try again later'];
        
        // ---- step 1, send ETH from customer account to main account... nhung bay gio,

        $token=$request->session()->get('token');
      
        $ltr1='http://35.185.180.127:3000/api/SendETH';
        
        $eth_toexchange=$request->eth_toexchange;
       
          $client1 = new Client([
            
             'base_uri' => $ltr1,               
             'timeout'  => 20.0,
             'headers' => [
                'Authorization'=>$token                         
                ],
             'form_params' => [
                'valueETH'=>$eth_toexchange,
				'addressReceive'=> $mainAccountAddress,
				'sendFrom'=>'buylottery'
				]
                
            ]);

		

		   $response1 = $client1->request('POST');  
		/*
		} catch (ClientException $e) {
		    return $error2;
		}
           */       
          $body1 = $response1->getBody();
         
          $json1 = json_decode($body1, true);



          // -- sign in Lottery main account to get Token

        $ltr2='http://35.185.180.127:3000/api/signin';

          $client2 = new Client([
            
             'base_uri' => $ltr2,               
             'timeout'  => 20.0,
             'form_params' => [
                'email'=>$mainAccountEmail,	              
                'password'=>$mainAccountPassword        
                ]
            ]);

        
		   $response2=$client2->request('POST');
		   // RequestException ? chua handle
	/*
		

		 catch (ClientException $e) {
		    return $error1;
		}
   		catch (RequestException $e) {
		    return $error2;
		}
   		catch (ConnectException $e) {
		    return $error3;
		}
		*/
          $body2 = $response2->getBody(true);
          
          $json2 = json_decode($body2, true);
         
          $tokenmain='JWT '.$json2['token'];
         
          $ltr3='http://35.185.180.127:3000/api/SendLTR';
          $ltrtobuy=$request->ltr_more;
          $addressReceive=$request->account_no;

          $client3 = new Client([
            
             'base_uri' => $ltr3,               
             'timeout'  => 20.0,
             'headers' => [
                'Authorization'=>$tokenmain                          
                ],
             'form_params' => [
                'valueLTR'=>$ltrtobuy,
				'addressReceive'=> $addressReceive,
				'sendFrom'=>'buylottery'
				]
       
                
            ]);

		
		   $response3 = $client3->request('POST');  
		
		/* catch (ClientException $e) {
		    return $error2;
		}
           */       
          $body3 = $response3->getBody();
          error_log($body3);
          $json3 = json_decode($body3, true);          
              
        return view('frontend.game.success_buyltr',['ltrtobuy'=>$ltrtobuy, 
        											'eth_toexchange'=>$eth_toexchange,
        											'receipt1'=>$json1,
        											'receipt3'=>$json3]); 
        
    }
	//-----------end of transFormTicketsToString Function
	//-- Hien tai la dung ham nay de mua 1 ve, 1 game hoac nhieu ve 1 game.
	// --- De mua nhieu ve, nhieu game can thay doi function

public function checkoutSubmitold( Request $request )
	{
	if($request->isMethod("post")) {
		$totalCost = 0;
		$mingas=0.01; //0.05 ETH
		$ltr_balance=$request->ltr_account_balance;
		$eth_balance=$request->eth_account_balance;
		 
		if(!(\Hash::check($request->account_password, Auth::guard('web')->user()->password))) {
			// wrong password so force customer log out. Alert them..
			return redirect()->route('frontend.site.logout');
		}
		$games = session( '_cart' );
		foreach ( $games as $game ) {
			$totalCost += $game['cost'];
		}
		error_log('Total Cost for check out la:'.$totalCost);


		// Check ETH first

		if ($eth_balance < $mingas) {
			$eth_more=$mingas-$eth_balance;
			$request->session()->forget( '_cart' );
			return view('frontend.game.buy_more_eth',['eth_more'=>$eth_more] );
		}

		// Check LTR later
		
		 if ($ltr_balance < $totalCost) {  //-----
			
			$ethprice=220;//220 usd--get real time price via API
        	$usdltr=1000;//1000 ltr = 1 usd  ty gia tam tinh -- get realtime price via API
        	$ethltrrate=1/($ethprice*$usdltr); // gia cua ETH 200 usd, ty gia 1000 LTR = 1 
/*
        	eth_balance min =eth_toexchange + txcost for send ETH to main account + txcost to buy Tickets in the next step
            main account receive eth_toexchange and then  transfer LTR to customer account. but main account cost some txfee , so eth_toexchange need to plus some txfee in that...
*/
			$txfee= 0.000950679;  //unit in ETH, get avarage or max txfee recently via api, 
			$ltr_more=$totalCost-$ltr_balance;
			$eth_toexchange=$ltr_more*$ethltrrate+$txfee;
			$max_ltr_can_buy=round(($eth_balance-$txfee-$mingas)/$ethltrrate);
			$request->session()->forget( '_cart' );

			return view('frontend.game.buy_more_ltr',['ltr_balance'=>$ltr_balance,
												'eth_balance'=>$eth_balance,
												'ethltrrate'=>$ethltrrate,
												'eth_toexchange'=>$eth_toexchange,
												'txfee'=>$txfee,
												'ltr_more'=>$ltr_more,
												'max_ltr_can_buy'=>$max_ltr_can_buy
												]);	
		}
		
		// Check ETH Alsoreturn view('frontend.game.buyltr',['ltr_balance'=>$ltr_balance,
		
		// Kiem tra games count xem co bao nhieu game. Neu la 1 game thi tiep tuc
		$numberOfGames=count($games);
		//---------------------
		if ($numberOfGames > 1) {
			$multiTickets=[
				'typePrizeID'=>[],
		  		'valueUSD'=>[],
		  		'message'=>[],
		  		'buyFrom'=>'buylottery',
			];

			foreach ( $games as $game ) {
			  	//--------------
			  	$tickets = [];
			  	foreach ( $game['tickets'] as $ticket ) {
				  if (!($ticket['normal']==null)) { 
					 
					$tickets[] = [
						'game_id'         => $game['game']->id,
						'user_id'         => Auth::guard('web')->user()->id,
						'numbers'         => $ticket['normal'],
						'special_numbers' => $ticket['special'] ?? null,
						'price'           => $game['game']->ticket_price,
						'status'          => 1,
						'created_at'      => Carbon::now(),
						'txhash'		  => '0x'
					];

				  }
			    }

			    $typePrizeID=$this->transFormGameIDToString($tickets);
        		$valueUSD=0.05; //$totalCost*$currenLTRUSDrate; 
        		$message=$this->transFormMultiTicketToString($tickets);
        		 
        		$multiTickets['typePrizeID'][]=$typePrizeID;
        		$multiTickets['valueUSD'][]=$valueUSD;
			  	$multiTickets['message'][]=$message;	 
			  	
			    //-------------	
			}
	
			$receipt=$this->buyMultiNow($request, $multiTickets);
			$receiptArray=[];
			$receiptArray[]=$receipt;
			// Check if error in API, do not save tickets in database. 
			$tickets = [];

			foreach ( $games as $game ) {
				foreach ( $game['tickets'] as $ticket ) {
					if (!($ticket['normal']==null)) { 
						//print_r($ticket['normal']);
						$tickets[] = [
							'game_id'         => $game['game']->id,
							'user_id'         => Auth::guard('web')->user()->id,
							'numbers'         => $ticket['normal'],
							'special_numbers' => $ticket['special'] ?? null,
							'price'           => $game['game']->ticket_price,
							'status'          => 1,
							'created_at'      => Carbon::now(),
							'txhash'		  => $receipt['TxHash']
						];

					}
				}
			}

			Ticket::insert( $tickets );
			$request->session()->forget( '_cart' );
			return view('frontend.game.success_checkout',[
				'count'=>count($receiptArray),
				'receiptArray'=>$receiptArray
		]);

//---------------

		}
		//---------1 game begin
		foreach ( $games as $game ) {
			foreach ( $game['tickets'] as $ticket ) {
				if (!($ticket['normal']==null)) { 
					//print_r($ticket['normal']);
					$tickets[] = [
						'game_id'         => $game['game']->id,
						'user_id'         => Auth::guard('web')->user()->id,
						'numbers'         => $ticket['normal'],
						'special_numbers' => $ticket['special'] ?? null,
						'price'           => $game['game']->ticket_price,
						'status'          => 1,
						'created_at'      => Carbon::now(),
						'txhash'		  => '0x'
					];

				}
			}
		}
		 
		$currenLTRUSDrate=0.001; // Get this rate online via a function
		$numberOfTickets=count($tickets); 
		
		$typePrizeID=$this->transFormGameIDToString($tickets);
        $valueUSD=0.05; //$totalCost*$currenLTRUSDrate; 
        $message=$this->transFormTicketsToString($tickets);
        $buyFrom='buylottery';

		$receipt=$this->buyNow($request, $typePrizeID, $valueUSD ,$message ,$buyFrom);	
		
		$tickets = [];

		foreach ( $games as $game ) {
			foreach ( $game['tickets'] as $ticket ) {
				if (!($ticket['normal']==null)) { 
					//print_r($ticket['normal']);
					$tickets[] = [
						'game_id'         => $game['game']->id,
						'user_id'         => Auth::guard('web')->user()->id,
						'numbers'         => $ticket['normal'],
						'special_numbers' => $ticket['special'] ?? null,
						'price'           => $game['game']->ticket_price,
						'status'          => 1,
						'created_at'      => Carbon::now(),
						'txhash'		  => $receipt['TxHash']
					];

				}
			}
		}
		 

		Ticket::insert( $tickets );

		$request->session()->forget( '_cart' );
		$receiptArray=[];
		$receiptArray[]=$receipt;

		return view('frontend.game.success_checkout',[
			'count'=>count($receiptArray),
			'receiptArray'=>$receiptArray
		]);
	}
	}





	public function checkoutSubmit( Request $request )
	{
	if($request->isMethod("post")) {
		$totalCost = 0;
		$mingas=0.05; //0.05 ETH
		$ltr_balance=$request->ltr_account_balance;
		$eth_balance=$request->eth_account_balance;
		 
		if(!(\Hash::check($request->account_password, Auth::guard('web')->user()->password))) {
			// wrong password so force customer log out. Alert them..
			return redirect()->route('frontend.site.logout');
		}
		$games = session( '_cart' );
		foreach ( $games as $game ) {
			$totalCost += $game['cost'];
		}
		error_log('Total Cost for check out la:'.$totalCost);
		// Check LTR first
		if ($ltr_balance < $totalCost) {  //-----
			$ltr_more=$totalCost-$ltr_balance;
			$request->session()->forget( '_cart' );
			return view('frontend.game.buy_more_ltr',['ltr_more'=>$ltr_more] );
		}
		// Check ETH Also

		if ($eth_balance < $mingas) { //----
			$eth_more=$mingas-$eth_balance;
			$request->session()->forget( '_cart' );
			return view('frontend.game.buy_more_eth',['eth_more'=>$eth_more] );
		}
		 		
		
		$currenLTRUSDrate=0.001; // Get this rate online via a function
		$receiptArray=[];


		foreach ( $games as $game ) {

			$tickets = [];


			foreach ( $game['tickets'] as $ticket ) {
				if (!($ticket['normal']==null)) { 
					//print_r($ticket['normal']);
					$tickets[] = [
						'game_id'         => $game['game']->id,
						'user_id'         => Auth::guard('web')->user()->id,
						'numbers'         => $ticket['normal'],
						'special_numbers' => $ticket['special'] ?? null,
						'price'           => $game['game']->ticket_price,
						'status'          => 1,
						'created_at'      => Carbon::now()
					];

				}
			}
			
			$numberOfTickets=count($tickets);
			$typePrizeID=$this->transFormGameIDToString($tickets);
			$valueUSD=$game['cost']*$currenLTRUSDrate; 
			$message=$this->transFormTicketsToString($tickets);
			$buyFrom='buylottery';        

			$receipt=$this->buyNow($request, $typePrizeID, $valueUSD ,$message ,$buyFrom);
		 	/*$receipt=[
		 		"TxHash"=>'0x-'.$message,
		 		'LTRValue'=>$game['cost']
		 	];*/
		 	
		 	$receiptArray[]=$receipt;
			Ticket::insert( $tickets );

		}


		$request->session()->forget( '_cart' );

		return view('frontend.game.success_checkout',[
			'count'=>count($receiptArray),
			'receiptArray'=>$receiptArray
		]);

		
	}
	}
}
