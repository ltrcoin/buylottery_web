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



//----Begin G --Return Account Balance ETH  -- Call EtherScan Account API
//    

public function g_account_balance(Request $request, $address) 
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

public function g_ltr_account_balance(Request $request, $contractaddress, $address) 
    {       
/*         
https://api.etherscan.io/api?module=account&action=tokenbalance&contractaddress=0x22b7eea5e111f6563fec76f65fa4da1985b41035&address=0x0530977c34b1623Dc4D4557F1E2ED94Ea6EAF5aD 

     
 Get Ether Balance for a single Address

https://api-ropsten.etherscan.io/api?module=account&action=balance&address=0xddbd2b932c763ba5b1b7ae3b362eac3e8d40121a&tag=latest&apikey=YourApiKeyToken
*/
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

//------------end G --AccountBalance function
//-----Return Account Balance LTR, ETH  
//     Return '-1' or '-2' if error
/*
public function account_balance(Request $request, $email, $password) 
    {       
          
        $error1=['ETHBalance'=>-1, 'LTRBalance'=>'ClientException. Try again later'];
        $error2=['ETHBalance'=>-2, 'LTRBalance'=>'RequestException. Try again later'];
        $error3=['ETHBalance'=>-3, 'LTRBalance'=>'ConnectException. Try again later'];

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
		    return $error2;
		}
                  
          $body3 = $response3->getBody();
          error_log($body3);
          $json3 = json_decode($body3, true);          
              
        return $json3;
        
    }

//------------end AccountBalance function
*/

public function g_buyNow(Request $request, $typePrizeID, $valueUSD ,$message ,$buyFrom) 
    {       
    	$address=Auth::guard('web')->user()->wallet_ltr;

		$pkey=ltrim(Auth::guard('web')->user()->pkey,'0x');


 $ltr5='http://eth-nmgiangoki316362.codeanyapp.com:8081/api/sendtx/'.$address.'/'.$pkey.'/'.$message;

          $client5 = new Client([
            
             'base_uri' => $ltr5,               
             'timeout'  => 30.0,
             
            ]
             
        );

		 $response5 = $client5->request('GET');
		 $body5 = $response5->getBody();
           
         $json5 = json_decode($body5, true);    

         $receipt=[
		 		"TxHash"=>$json5['transactionHash'],
		 		'LTRValue'=>500
		 	];
		 	      
              
        return $receipt;
        
    }

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

//------------end BuyLotter function

	public function checkout(Request $request)
	{
		$games     = session( '_cart' );
		$totalCost = 0;
		//$balance=$this->account_balance($request, Auth::guard('web')->user()->email, 
		//										  Auth::guard('web')->user()->password);
		$contractAddress='0x22b7eea5e111f6563fec76f65fa4da1985b41035'; //LTR Contract Add
		//$eth_balance=$balance['ETHBalance'];
		$address=Auth::guard('web')->user()->wallet_ltr;
		$eth_etherscan_balance=$this->g_account_balance($request, $address);
$ltr_etherscan_balance=$this->g_ltr_account_balance($request, $contractAddress,$address);

		$eth_balance=$eth_etherscan_balance['result']/1000000000000000000;
		//$ltr_balance=$balance['LTRBalance'];
		$ltr_balance=$ltr_etherscan_balance['result']/1000000000000000000;


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

public function transFormGameIDToString($tickets) {

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
//-----------End of transFormGameIDToString Function


//-----------Begin of transFormTicketsToString Function
	//-----------Used for API Call to Buy Ticket in LTR
public function transFormTicketsToString($tickets) {

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

	
public function buyltr(Request $request) 
    {       
    	// Buy LTR se co 2 viec, 1

    	// la chuyen ETH trong vi  hien tai dang login cua khach sang vi ETH cua Lottery
    	// Sau khi vi ETH cua Lottery nhan duoc so ETH can thiet, vi Lotter se chuyen LTR 
    	// vao vi cua khach. Hien tai lam truoc buoc 2, la chuyen tu vi Lottery (ansangGmailcom) sang vi cua khach (vi nodeeth gmailcom)
         
        $ltrtobuy=$request->ltr_more;
        $addressReceive=$request->account_no;
        $ethprice=220;//220 usd
        $usdltr=10;//10 ltr = 1 usd  ty gia tam tinh
        $ethltrrate=1/($ethprice*$usdltr); // gia cua ETH 200 usd, ty gia 1000 LTR = 1 usd

        $error1=['error'=>'ClientException. Try again later'];
        $error2=['error'=>'RequestException. Try again later'];
        $error3=['error'=>'ConnectException. Try again later'];

        //--- step 1, transfer ETH from customer account (nodeeth) to main account (ansang@gmail)-- sau khi Hung viet xong APi se dung API cua Hung. Truoc mat dung API cua Giang voi testnet Ropsten ETH.

		$address=Auth::guard('web')->user()->wallet_ltr;
		$pkey=ltrim(Auth::guard('web')->user()->pkey,'0x');
		$value=$ltrtobuy*$ethltrrate;

		// so ETH can chuyen de mua so LTR tuong ung, theo ty gia ETH/LTR hien tai


 		$ltr5='http://eth-nmgiangoki316362.codeanyapp.com:8081/api/sendeth/'.$address.'/'.$pkey.'/'.$value;

          $client5 = new Client([
            
             'base_uri' => $ltr5,               
             'timeout'  => 10.0,
             
            ]
             
        );

		 $response5 = $client5->request('GET');
		 /*$body5 = $response5->getBody();
           
         $json5 = json_decode($body5, true);    

         $receipt=[
		 		"TxHash"=>$json5['transactionHash'],
		 		'LTRValue'=>500
		 	];
		*/

        //-- step 2, transfer LTR from main account to customer account
          // -- sign in Lottery main account to get Token

        $ltr2='http://35.185.180.127:3000/api/signin';

          $client2 = new Client([
            
             'base_uri' => $ltr2,               
             'timeout'  => 9.0,
             'form_params' => [
                'email'=>'ansang@gmail.com',	
                // email cua tai khoan main account chuyen dung de ban LTR cho customer
                // tam dung an sang
                'password'=>'$2y$10$5woBPaOBG1KuqYPzVtxWiOVIVxekDA12ZTPRWHL5yvnBZVHPSJOA.'
                // password cua tai khoan main account          
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

          $ltr3='http://35.185.180.127:3000/api/SendLTR';
          

          $client3 = new Client([
            
             'base_uri' => $ltr3,               
             'timeout'  => 9.0,
             'headers' => [
                'Authorization'=>$token                          
                ],
             'form_params' => [
                'valueLTR'=>$ltrtobuy,
				'addressReceive'=> $addressReceive,
				'sendFrom'=>'buylottery'
				]
       
                
            ]);

		try {
		   $response3 = $client3->request('POST');  
		} catch (ClientException $e) {
		    return $error2;
		}
                  
          $body3 = $response3->getBody();
          error_log($body3);
          $json3 = json_decode($body3, true);          
              
        return view('frontend.game.success_buyltr',['ltrtobuy'=>$ltrtobuy, 
        											'receipt'=>$json3]); 
        
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
			return view('frontend.game.buy_more_ltr',['ltr_balance'=>$ltr_balance,
												'eth_balance'=>$eth_balance,
												'ltr_more'=>$ltr_more
												]);	
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
			switch ($game['game']->id) {
				case 1:
					$message='E'.$message; //EuroJackpot
					break;
				case 2:
					$message='M'.$message;// Megamillion
					break;
				case 3:
					$message='L'.$message;//Lottery Jackpot
					break;	
			}
			$buyFrom='buylottery';        

			//$receipt=$this->buyNow($request, $typePrizeID, $valueUSD ,$message ,$buyFrom);
			$receipt=$this->g_buyNow($request, $typePrizeID, $valueUSD ,$message ,$buyFrom);

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
