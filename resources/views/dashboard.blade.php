@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Auction Links -->
            <div>
                <a href="{{ route('auctions.index') }}" class="text-blue-600 hover:underline">All Auctions</a><br>
                <a href="{{ route('auctions.create') }}" class="text-blue-600 hover:underline">Create New Auction</a>
            </div>
        </div>
    </div>
@endsection 