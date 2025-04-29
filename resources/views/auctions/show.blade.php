@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/auction.css') }}" rel="stylesheet">

    <div class="container">
        <div class="auction-container">

            <h2>{{ $auction->title }}</h2>
            <p>{{ $auction->description }}</p>
            <p><strong>Current Price:</strong>
                ${{ $auction->bids()->latest()->first()->amount ?? $auction->starting_price }}</p>
            <p><strong>Ends At:</strong> {{ $auction->ends_at }}</p>
            <p><strong>Ends In:</strong> <span id="timer"></span></p>

            @if(Auth::check())
                @if(auth()->user()->wallet)
                    <p><strong>Your Wallet Balance:</strong> ${{ auth()->user()->wallet->balance }}</p>

                    <div class="bid-form-container">
                        <!-- Place Bid Form -->
                        <form id="placeBidForm" method="POST" action="{{ route('bids.store', $auction) }}">
                            @csrf
                            <input class="form-control" type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input class="form-control" type="number" step="0.01" name="amount" placeholder="Your bid" required
                                min="{{ $auction->current_price }}">
                            <button class="btn-glow" type="submit">Place Bid</button>
                        </form>

                        <!-- Add Balance Form -->
                        <form id="addBalanceForm" method="POST" action="{{ route('wallet.update', auth()->user()) }}"
                            style="margin-top:15px;">
                            @csrf
                            @method('PATCH')
                            <input class="form-control" type="number" step="0.01" name="amount" placeholder="Amount to Add" required
                                min="0">
                            <button class="btn-glow-secondary" type="submit">Add Balance</button>
                        </form>

                    </div>

                @else
                    <p style="color:red;">Your wallet is missing! Please create a wallet first.</p>
                    <form method="POST" action="{{ route('wallet.create') }}">
                        @csrf
                        <button class="btn-glow-secondary" type="submit">Create Wallet</button>
                    </form>
                @endif
            @else
                <p>Please log in to place a bid and create a wallet.</p>
            @endif



            <h4 style="margin-top:30px;">Bids:</h4>
            <ul>
                @forelse($auction->bids()->latest()->get() as $bid)
                    <li>${{ $bid->amount }} by {{ $bid->user->name ?? 'Unknown User' }}
                        ({{ $bid->created_at->diffForHumans() }})</li>
                @empty
                    <li>No bids yet!</li>
                @endforelse
            </ul>
            @if(Auth::check() && Auth::user()->id === $auction->user_id)
                <form id="deleteAuctionForm" method="POST" action="{{ route('auctions.destroy', $auction) }}"
                    style="margin-top: 20px;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" id="deleteAuctionButton">
                        Delete Auction
                    </button>
                </form>
            @endif

        </div> <!-- .auction-container -->
    </div> <!-- .container -->

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const endTime = new Date("{{ \Carbon\Carbon::parse($auction->ends_at)->format('Y-m-d H:i:s') }}").getTime();
        const timer = document.getElementById('timer');

        function updateTimer() {
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
        }

        const interval = setInterval(updateTimer, 1000);
        updateTimer();

        // SweetAlert on success or error
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Loading animation when placing a bid
        document.getElementById('placeBidForm').addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Placing your bid...',
                html: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            setTimeout(() => {
                this.submit();
            }, 500);
        });

        // Loading animation when adding balance
        document.getElementById('addBalanceForm').addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Adding balance...',
                html: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            setTimeout(() => {
                this.submit();
            }, 500);
        });

        document.getElementById('deleteAuctionButton')?.addEventListener('click', function (e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this auction deletion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteAuctionForm').submit();
                }
            });
        });

    </script>

@endsection