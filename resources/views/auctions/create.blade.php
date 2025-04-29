@extends('layouts.app')

@section('content')
    <!-- Link external stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auction-create.css') }}">

    <!-- Toast CSS (you can put this in your CSS if you want) -->
    <style>
        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #00c6ff;
            color: white;
            text-align: center;
            border-radius: 10px;
            padding: 16px;
            position: fixed;
            z-index: 1000;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from { bottom: 0; opacity: 0; }
            to { bottom: 30px; opacity: 1; }
        }

        @keyframes fadeout {
            from { bottom: 30px; opacity: 1; }
            to { bottom: 0; opacity: 0; }
        }
    </style>

    <div class="container py-5" style="min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card auction-form-card p-5">
                    <h1 class="text-center mb-4">Create New Auction</h1>

                    <form method="POST" action="{{ route('auctions.store') }}">
                        @csrf
                        <div class="form-group mb-4">
                            <input type="text" name="title" class="form-control" placeholder="Enter Auction Title" required>
                        </div>

                        <div class="form-group mb-4">
                            <textarea name="description" rows="4" class="form-control" placeholder="Enter Description" required></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <input type="number" name="starting_price" class="form-control" placeholder="Enter Starting Price ($)" required>
                        </div>

                        <div class="form-group mb-4">
                            <input type="datetime-local" name="ends_at" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Create Auction</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Toast container -->
    <div id="toast">Auction Created Successfully!</div>

    <!-- Show toast if success -->
    @if(session('success'))
        <script>
            window.onload = function() {
                var x = document.getElementById("toast");
                x.className = "show";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
        </script>
    @endif

@endsection