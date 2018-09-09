<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Frontend\Winner;

class WinnerController extends Controller
{
    public function index() {
        // get winner
        $pageSize = Winner::PAGE_SIZE;
        $winners = Winner::with(['customer', 'game', 'ticket', 'prize', 'winningnumber'])
                        ->orderBy('user_id')
                        ->paginate($pageSize);
        $data = [
            'winners' => $winners
        ];

    	return view("frontend.winner.index", $data);
    }

    public function detail($id) {
        $customers = [
          ['G.A.', '10000', 'BTC', 'Euro Jackpot','G.A. from Panama won our biggest lottery prize ever when he matched the six winning numbers in the Florida Lotto draw on 19 July 2017, becoming the sole winner of the 10000 BTC jackpot. theLotter flew him to Florida to collect him prize. We are excited and proud of him amazing win.'],
          ['G.', '20000', 'BTC', 'Euro Jackpot', "G. was our first jackpot winner ever when he matched all six winning numbers in the Oregon Megabucks draw on 24 August 2015, becoming the sole winner of the 20000 BTC jackpot! theLotter flew him across the world to Oregon to claim his prize and we couldn't be happier for him!"],
          ['M.A', '30000', 'BTC', 'Euro Jackpot', "M.A. has been playing online with theLotter from Australia since 2003. Dogged and determined a player, M.A. has had 452 wins over the years but nothing close to the $1 million US Powerball second prize he won on 19 October 2016 by choosing all five main numbers correctly. M.A.’s advice to other lottery players: ‘Never doubt yourself and keep your faith’ Sage wisdom from someone who would know!"],
          ['G.T', '40000', 'BTC', 'Euro Jackpot', "G.T. lost 3.5 kilos in the 2 days after discovering he had won the Austria Lotto online from Russia. The lucky Muscovite driver had only recently started playing lotteries from outside of Russia online – always with a set of random numbers. Both G.T. as well as his wife Tatiana are over the moon about their fortune and G.T. spoke to us at length in Vienna when he picked up the jackpot!"],
          ['J.S', '50000', 'BTC', 'Euro Jackpot', "Like thousands of other Canadians, J.S from Quebec started playing lottery online with theLotter when the US Powerball jackpot hit $1 billion. Luckily for J.S, he kept playing Powerball after the billion-dollar jackpot fell and won the $1 million second prize on 27 February 2016! We're overjoyed that we could help J.S achieve his dream of becoming a lottery millionaire!"],
          ['N.H', '60000', 'BTC', 'Euro Jackpot', "N.H. from El Salvador started playing with theLotter when the US Powerball lottery hit the billion-dollar mark. This was a really smart decision because H.V. matched all five main numbers in the 13 January 2016 draw, winning the $1 million second prize! "],
          ['N.B', '70000', 'BTC', 'Euro Jackpot', 'N.B. subscribed to US Powerball and immediately won a MASSIVE second place $1 million prize in 2012! theLotter gave B.U a luxurious trip from the UK to Florida to collect his earnings. "I still believe that I will win the top prize and winning $1 million with theLotter has been great practice for when I do!"'],
          ['Nataliia’s', '80000', 'BTC', 'Euro Jackpot', 'Nataliia’s birthday present came a week early when she won $1 million playing US Mega Millions online on 26 September 2017! Since finding theLotter in 2015, Nataliia played all the biggest jackpots in the world with subscriptions to make sure she’d never miss a draw. After working so hard for so long to win, it took some convincing that she’d actually won! Once she realized it was true she could not have been happier! '],
        ];
        return response()->json([
            'name' => $customers[$id][0],
            'prize' => number_format($customers[$id][1]).' '.$customers[$id][2],
            'description' => $customers[$id][4],
            'image' => asset('icon/demo/win'.$id.'.jpg')
        ]);
    }
}
