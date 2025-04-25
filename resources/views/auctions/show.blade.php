@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <h2>{{ $auction->title }}</h2>
        <p>{{ $auction->description }}</p>
        <p>Current Price: ${{ $auction->bids()->latest()->first()->amount ?? $auction->starting_price }}</p>
        <p>Ends At: {{ $auction->ends_at }}</p>
        <p><strong>Ends In:</strong> <span id="timer"></span></p>

        @auth
            <p>Your Wallet Balance: ${{ auth()->user()->wallet->balance }}</p>
            <form method="POST" action="{{ route('bids.store', $auction) }}">
                @csrf
                <input type="number" step="0.01" name="amount" placeholder="Your bid" required
                    min="{{ $auction->starting_price }}">
                <button type="submit">Place Bid</button>
            </form>
        @endauth

        <h4>Bids:</h4>
        <ul>
            @foreach($auction->bids()->latest()->get() as $bid)
                <li>${{ $bid->amount }} by {{ $bid->user->name ?? 'Unknown User' }} ({{ $bid->created_at }})</li>
            @endforeach
        </ul>
    </div>

    <script>
        const endTime = new Date("{{ \Carbon\Carbon::parse($auction->ends_at)->format('Y-m-d H:i:s') }}").getTime();

        const timer = document.getElementById('timer');
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(interval);
                timer.innerHTML = "Auction Ended";
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timer.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
        }, 1000);
    </script>
@endsection