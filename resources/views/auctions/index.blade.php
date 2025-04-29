@extends('layouts.app')

@section('content')
    <!-- Link external stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auction-index.css') }}">
    <div class="container-fluid py-5" style="min-height: 100vh;">
        <div class="text-center mb-4">
            <a href="{{ route('auctions.create') }}" class="btn btn-success btn-lg">Create New Auction</a>
        </div>

        <h2 class="text-center mb-5" style="font-weight: bold;">All Auctions</h2>

        <div class="row justify-content-center">
            @foreach($auctions as $auction)
                <div class="col-md-8 mb-4">
                    <div class="card auction-card p-4">
                        @if(isset($auction->image_url))
                            <img src="{{ $auction->image_url }}" alt="Auction Image" class="auction-image mb-3">
                        @else
                            <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder Image"
                                class="auction-image mb-3">
                        @endif
                        <h4 class="mb-2 auction-title">
                            <a href="{{ route('auctions.show', $auction) }}">{{ $auction->title }}</a>
                        </h4>

                        <p class="mb-2">{{ $auction->description }}</p>

                        <p class="mb-1"><strong>Current Price:</strong>
                            ${{ $auction->current_price ?? $auction->starting_price }}</p>

                        <p class="mb-3">
                            <strong>Ends In:</strong>
                            @if(\Carbon\Carbon::now()->greaterThan($auction->ends_at))
                                <span class="text-danger">Auction Ended</span>
                            @else
                                <span class="countdown" data-end="{{ $auction->ends_at }}"></span>
                            @endif
                        </p>

                        <div class="text-center">
                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-primary w-100">Place a Bid</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </>

        <!-- Countdown Timer Script -->
        <script>
            document.querySelectorAll('.countdown').forEach(function (el) {
                const endTime = new Date(el.dataset.end).getTime();

                const updateCountdown = () => {
                    const now = new Date().getTime();
                    const distance = endTime - now;

                    if (distance < 0) {
                        el.innerHTML = "Auction Ended";
                        return;
                    }

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    el.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
                };

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });
        </script>
@endsection