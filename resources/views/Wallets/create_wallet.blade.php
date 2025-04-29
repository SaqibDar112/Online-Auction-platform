@if(!$user->wallet)
    <form action="{{ route('wallet.create', $user) }}" method="POST">
        @csrf
        <button type="submit">Create Wallet</button>
    </form>
@else
    <p>You already have a wallet.</p>
@endif
