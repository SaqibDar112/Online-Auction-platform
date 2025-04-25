<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BidController extends Controller {
    public function store(Request $request, Auction $auction) {
        $request->validate(['amount' => 'required|numeric|gt:' . $auction->current_price]);

        $bid = new Bid([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        $auction->bids()->save($bid);
        $auction->current_price = $request->amount;
        $auction->save();

        return back();
    }
}