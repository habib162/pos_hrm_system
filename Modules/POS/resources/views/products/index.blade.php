@extends('core::layouts.app')
@section('title', 'Products')

@section('content')
@livewire(\Modules\POS\App\Livewire\Products\ProductList::class)
@endsection
