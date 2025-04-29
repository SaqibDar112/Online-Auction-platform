<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Create a wallet for the authenticated user
    public function createWallet()
    {
        $user = auth()->user();  // Get the authenticated user

        // Check if the user already has a wallet
        if (!$user->wallet) {
            // Create a wallet for the user
            $user->wallet()->create([
                'balance' => 0.00, // Set initial balance to 0
            ]);

            // Return back with success message
            return redirect()->back()->with('success', 'Your wallet has been created!');
        }

        // If the user already has a wallet
        return redirect()->back()->with('error', 'You already have a wallet!');
    }
}
