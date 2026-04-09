@extends('core::layouts.app')
@section('title', 'Product Form')

@section('content')
@livewire(\Modules\POS\App\Livewire\Products\ProductForm::class, ['productId' => $productId ?? null])
@endsection
