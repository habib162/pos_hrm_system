@extends('core::layouts.app')
@section('title', 'Settings')

@section('content')
    @livewire(\Modules\Settings\App\Livewire\GeneralSettings::class)
@endsection
