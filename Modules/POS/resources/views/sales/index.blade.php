@extends('core::layouts.app')
@section('title', 'Sales History')

@section('content')
@livewire(\Modules\POS\App\Livewire\Sales\SaleList::class)
@endsection
