@extends('core::layouts.app')
@section('title', 'Customers')

@section('content')
@livewire(\Modules\POS\App\Livewire\Customers\CustomerList::class)
@endsection
