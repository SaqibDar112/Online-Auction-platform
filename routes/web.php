<?php
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [AuctionController::class, 'index'])->name('auctions.index');

Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
Route::post('/auctions/{auction}/bids', [BidController::class, 'store'])->name('bids.store');
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::post('/auctions/{id}/placeBid', [AuctionController::class, 'placeBid'])->name('auctions.placeBid');