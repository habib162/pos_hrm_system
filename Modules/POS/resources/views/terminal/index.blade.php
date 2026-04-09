@extends('core::layouts.app')
@section('title', 'POS Terminal')

@section('content')
@livewire(\Modules\POS\App\Livewire\POSScreen::class)
@endsection
