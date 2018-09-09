<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController as Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Frontend\WinningNumber;

class WinningController extends Controller
{
    public function index() {
        // get winner
        $pageSize = WinningNumber::PAGE_SIZE;
        $winnings = WinningNumber::with(['game'])
                        ->orderBy('game_id')
                        ->orderBy('winning_numbers.draw_date', 'DESC')
                        ->paginate($pageSize);
        $data = [
            'winnings' => $winnings
        ];

    	return view("frontend.winning.index", $data);
    }
}
