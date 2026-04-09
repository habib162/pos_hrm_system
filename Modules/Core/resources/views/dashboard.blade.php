@extends('core::layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="mb-6 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white">
    <h2 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
    <p class="text-indigo-200 mt-1">Here's what's happening in your business today &mdash; {{ now()->format('l, F j Y') }}</p>
</div>

@livewire(\Modules\Core\App\Livewire\Dashboard::class)

@endsection
