<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;
use App\Models\Auction;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $auctions = Auction::where('user_id', auth()->user()->id)->get();
    return view('dashboard', compact('auctions'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
    Route::resource('auctions', AuctionController::class);
    Route::post('/auctions/{auction}/bids', [BidController::class, 'store'])->name('bids.store');
    Route::post('/wallet/create', [WalletController::class, 'createWallet'])->name('wallet.create');
    Route::patch('/wallet/{user}/update', [WalletController::class, 'updateBalance'])->name('wallet.update');
    Route::post('/wallet/store', [WalletController::class, 'store'])->name('wallet.store');
});

require __DIR__ . '/auth.php';