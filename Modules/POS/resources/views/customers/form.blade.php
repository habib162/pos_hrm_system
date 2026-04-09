@extends('core::layouts.app')
@section('title', 'Customer Form')

@section('content')
@livewire(\Modules\POS\App\Livewire\Customers\CustomerForm::class, ['customerId' => $customerId ?? null])
@endsection
