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

//-----Return Account Balance LTR, ETH  
//     Return '-1' or '-2' if error

public function account_balance(Request $request, $email, $password) 
    {       
          
        $error1=['ETHBalance'=>-1, 'LTRBalance'=>-1];
        $error2=['ETHBalance'=>-2, 'LTRBalance'=>-2];
        $error3=['ETHBalance'=>-3, 'LTRBalance'=>-3];

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

         $response5 = $client5->request('POST');

         // try catch error

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

	//-----------end of transFormTicketsToString Function


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
		if ($ltr_balance < $totalCost) {
			$ltr_more=$totalCost-$ltr_balance;
			$request->session()->forget( '_cart' );
			return view('frontend.game.buy_more_ltr',['ltr_more'=>$ltr_more] );
		}
		// Check ETH Also

		if ($eth_balance < $mingas) {
			$eth_more=$mingas-$eth_balance;
			$request->session()->forget( '_cart' );
			return view('frontend.game.buy_more_eth',['eth_more'=>$eth_more] );
		}
		 		
		
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
						'created_at'      => Carbon::now()
					];

				}
			}
		}
		 
		$currenLTRUSDrate=0.001; // Get this rate online via a function
		$numberOfTickets=count($tickets);
		
		$typePrizeID=$this->transFormGameIDToString($tickets);
        $valueUSD=$totalCost*$currenLTRUSDrate; 
        $message=$this->transFormTicketsToString($tickets);
        $buyFrom='buylottery';

		$receipt=$this->buyNow($request, $typePrizeID, $valueUSD ,$message ,$buyFrom);	
		 
		Ticket::insert( $tickets );

		$request->session()->forget( '_cart' );

		return view('frontend.game.success_checkout',[
			'txhash'=>$receipt['TxHash'],
			'ltrvalue'=>$receipt['LTRValue']
		]);
	}
	}
}
