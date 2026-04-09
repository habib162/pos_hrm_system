@extends('core::layouts.app')
@section('title', 'Categories')

@section('content')
@livewire(\Modules\POS\App\Livewire\Categories\CategoryList::class)
@endsection
