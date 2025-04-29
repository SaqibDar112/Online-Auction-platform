<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Models\Wallet;

class BidController extends Controller
{
    public function store(Request $request, Auction $auction)
    {
        $request->validate([
            'amount' => 'required|numeric|min:' . ($auction->current_price + 0.01),
        ]);

        $user = auth()->user();

        if (!$user || !$user->wallet) {
            return back()->with('error', 'You must create a wallet first.');
        }

        if ($user->wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }
        $bid = new Bid();
        $bid->user_id = $user->id;
        $bid->amount = $request->amount;

        $auction->bids()->save($bid);
        $auction->current_price = $request->amount;
        $auction->save();
        $user->wallet->balance -= $request->amount;
        $user->wallet->save();
        return back()->with('success', 'Bid placed successfully!');
    }


    public function topUp(Request $request)
    {
        $user = auth()->user();
        if (!$user || !$user->wallet) {
            return back()->with('error', 'User or Wallet not found.');
        }
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $user->wallet->balance += $request->amount;
        $user->wallet->save();
        return back()->with('success', 'Wallet topped up successfully!');
    }

    public function createWallet(Request $request)
    {
        $user = auth()->user();
        if ($user->wallet) {
            return back()->with('error', 'You already have a wallet.');
        }
        $request->validate([
            'balance' => 'required|numeric|min:0',
        ]);
        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->balance = $request->balance;
        $wallet->save();
        return back()->with('success', 'Wallet created successfully!');
    }
}