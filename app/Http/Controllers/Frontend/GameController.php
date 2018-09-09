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

class GameController extends Controller
{
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

		return view( 'frontend.game.cart', compact( 'games', 'totalCost' ) );
	}

//-----Return LTR Balance  
//     Return '-1' or '-2' if error

public function ltrbalance($email, $password) 
    {       
          
        $error1=-1;
        $error2=-2;

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
		} catch (ClientException $e) {
		    return $error1;
		}
   
          $body2 = $response2->getBody(true);
          error_log($body2);
          $json2 = json_decode($body2, true);
         
          $token='JWT '.$json2['token'];

          // -- Get LTR Wallet Address and return it

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
              
        return $json3['LTRBalance'];
        
    }

//------------end LTRBalance function



	public function checkout()
	{
		$games     = session( '_cart' );
		$totalCost = 0;
		$balance=$this->ltrbalance(Auth::guard('web')->user()->email, 
									Auth::guard('web')->user()->password);

		foreach ( $games as $game ) {
			$totalCost += $game['cost'];
		}

		return view( 'frontend.game.checkout', compact( 'games', 'totalCost','balance' ) );
	}

	public function checkoutSubmit( Request $request )
	{
	if($request->isMethod("post")) {
		$totalCost = 0;
		$balance=number_format($request->account_balance);
		error_log('LTR Balance khi check out la:'.$balance);
		error_log('Password for check out la:'.$request->account_password);
		if(!(\Hash::check($request->account_password, Auth::guard('web')->user()->password))) {
			// wrong password so force customer log out. Alert them..
			return redirect()->route('frontend.site.logout');
		}
		$games = session( '_cart' );
		foreach ( $games as $game ) {
			$totalCost += $game['cost'];
		}
		error_log('Total Cost for check out la:'.$totalCost);

		if ($balance < $totalCost) {
			$ltr_more=$totalCost-$balance;
			$request->session()->forget( '_cart' );
			return view( 'frontend.game.buy_more_ltr',['ltr_more'=>$ltr_more] );
		}
		// call api to transfer LTR from customer wallet to LTR Co Wallet.
		// If OK, then save tickets into database
		
		$tickets = [];

		foreach ( $games as $game ) {
			foreach ( $game['tickets'] as $ticket ) {
				if (!($ticket['normal']==null)) { 
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

		Ticket::insert( $tickets );

		$request->session()->forget( '_cart' );

		return view( 'frontend.game.success_checkout' );
	}
	}
}
