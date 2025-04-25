<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
class AuctionController extends Controller
{
    public function index()
    {
        $auctions = \App\Models\Auction::all();
        return view('auctions.index', ['auctions' => Auction::latest()->get()]);
    }

    public function create()
    {
        return view('auctions.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric',
            'ends_at' => 'required|date',
        ]);
        $validated['user_id'] = 1;
        Auction::create($validated);
        return redirect()->route('auctions.index')->with('success', 'Auction created successfully!');

    }

    public function show($id)
    {
        $auction = Auction::with('bids')->findOrFail($id);
        return view('auctions.show', compact('auction'));
    }
    public function placeBid(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $user = auth()->user();
        $wallet = $user->wallet;
        $request->validate([
            'amount' => 'required|numeric|min:' . $auction->starting_price,
        ]);

        if ($wallet->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance to place the bid.');
        }

        $bid = new \App\Models\Bid;
        $bid->auction_id = $auction->id;
        $bid->user_id = $user->id;
        $bid->amount = $request->amount;
        $bid->save();
        $wallet->balance -= $request->amount;
        $wallet->save();

        return redirect()->back()->with('success', 'Bid placed successfully!');
    }
}