<?php

namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Notifications\Notification;

class AuctionWon extends Notification
{
    private $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You have won the auction for "' . $this->auction->title . '"!')
                    ->action('View Auction', url('/auctions/' . $this->auction->id))
                    ->line('Thank you for using our auction platform!');
    }
}
