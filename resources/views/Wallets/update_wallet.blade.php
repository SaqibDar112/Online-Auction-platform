<form action="{{ route('wallet.update', $user) }}" method="POST">
    @csrf
    <input type="number" name="amount" placeholder="Enter amount" required min="0">
    <button type="submit">Update Wallet Balance</button>
</form>