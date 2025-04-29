<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>

                <!-- Display Auctions -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-700">Your Auctions</h3>

                    @if($auctions->isEmpty())
                        <p>No auctions created yet. <a href="{{ route('auctions.create') }}" class="text-blue-500">Create a
                                new auction</a></p>
                    @else
                        <ul class="mt-4 space-y-4">
                            @foreach($auctions as $auction)
                                <li class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <a href="{{ route('auctions.show', $auction->id) }}" class="font-semibold text-blue-600">
                                        {{ $auction->title }}
                                    </a>
                                    <p class="text-sm text-gray-500">{{ $auction->description }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>