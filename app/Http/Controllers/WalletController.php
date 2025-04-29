<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    // Create a wallet for the user
    public function createWallet(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a wallet.');
        }

        if ($user->wallet) {
            return redirect()->back()->with('error', 'Wallet already exists!');
        }

        $user->wallet()->create([
            'balance' => 0,
        ]);

        return redirect()->back()->with('success', 'Wallet created successfully!');
    }


    // Update wallet balance (for bidding purposes)

    // Update wallet balance (for bidding purposes)
    public function updateBalance(Request $request, User $user)
    {
        // Ensure user is logged in
        if ($user->id !== auth()->id()) {
            return redirect()->route('login')->with('error', 'You can only update your own wallet.');
        }

        // Validate the amount
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Find the user's wallet and update the balance
        $wallet = $user->wallet;

        // Add the amount to the current balance
        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect()->back()->with('success', 'Wallet balance updated successfully!');
    }

}