<?php
namespace App\Console\Commands;

use App\Models\Auction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Notifications\AuctionWon;

class CloseAuctions extends Command
{
    protected $signature = 'auctions:close';
    protected $description = 'Close auctions and notify the winner';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $auctions = Auction::where('ends_at', '<=', Carbon::now())
            ->whereNull('closed_at')
            ->get();

        foreach ($auctions as $auction) {
            $highestBid = $auction->bids()->orderByDesc('amount')->first();
            if ($highestBid) {
                $highestBid->user->notify(new AuctionWon($auction));
                $auction->update(['closed_at' => Carbon::now()]);
                $this->info('Auction "' . $auction->title . '" closed. Winner: ' . $highestBid->user->name);
            } else {
                $this->info('Auction "' . $auction->title . '" closed, but no bids were placed.');
            }
        }
    }
}
