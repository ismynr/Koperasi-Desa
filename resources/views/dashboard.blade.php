<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            Hello {{auth()->user()->role == 1 ? 'Admin':'Member'}}, You're logged in!
        </div>
    </div>
</x-app-layout>