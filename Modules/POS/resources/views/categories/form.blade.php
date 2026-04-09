@extends('core::layouts.app')
@section('title', 'Category Form')

@section('content')
@livewire(\Modules\POS\App\Livewire\Categories\CategoryForm::class, ['categoryId' => $categoryId ?? null])
@endsection
