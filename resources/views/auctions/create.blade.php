@extends('layouts.app')

@section('content')
  <style>
    .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    }

    .form-control {
    border-radius: 8px;
    padding: 12px;
    font-size: 16px;
    }

    .btn-primary {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 8px;
    }

    h1 {
    font-size: 28px;
    font-weight: bold;
    }
  </style>

  <div class="container mt-5">
    <div class="card p-4">
    <h1 class="mb-4">Create Auction</h1>
    <form method="POST" action="{{ route('auctions.store') }}">
      @csrf
      <div class="mb-3">
      <input class="form-control" type="text" name="title" placeholder="Title" required>

      </div>
      <div class="mb-3">
      <textarea class="form-control" name="description" placeholder="Description" rows="4" required></textarea>
      </div>
      <div class="mb-3">
      <input class="form-control" type="number" name="starting_price" placeholder="Starting Price" required>
      </div>
      <div class="mb-3">
      <input class="form-control" type="datetime-local" name="ends_at" required>

      </div>
      <button class="btn btn-primary">Create Auction</button>
    </form>

    </div>
  </div>
@endsection