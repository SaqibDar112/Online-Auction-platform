@extends('layouts.app')

@section('content')
    <style>
        .auction-card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .auction-title {
            font-size: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .countdown {
            font-weight: bold;
            color: #dc3545;
        }

        .bid-button {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>

    <div class="container py-5" style="background-color: #f0f2f5; min-height: 100vh;">
        <div class="text-center mb-4">
            <a href="{{ route('auctions.create') }}" class="btn btn-success">Create New Auction</a>
        </div>

        <h2 class="text-center mb-5" style="font-weight: bold;">All Auctions</h2>

        <div class="row justify-content-center">
            @foreach($auctions as $auction)
                <div class="col-md-8 mb-4">
                    <div class="card shadow-sm p-4" style="border-radius: 15px; transition: transform 0.2s;">
                        <h4 class="mb-2" style="font-weight: bold; color: #007bff;">
                            <a href="{{ route('auctions.show', $auction) }}"
                                style="text-decoration: none;">{{ $auction->title }}</a>
                        </h4>
                        <p class="mb-1">{{ $auction->description }}</p>
                        <p class="mb-1"><strong>Current Price:</strong>
                            ${{ $auction->current_price ?? $auction->starting_price }}</p>
                        <p class="mb-3">
                            <strong>Ends At:</strong>
                            @if(\Carbon\Carbon::now()->greaterThan($auction->ends_at))
                                <span class="text-danger">Auction Ended</span>
                            @else
                                <span class="text-success">{{ \Carbon\Carbon::parse($auction->ends_at)->diffForHumans() }}</span>
                            @endif
                        </p>
                        <div class="text-center">
                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-primary">Place a Bid</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
    </style>

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