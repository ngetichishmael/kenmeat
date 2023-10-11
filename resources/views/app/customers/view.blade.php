@extends('layouts.app3')
@section('title', 'Customer Information')

@section('content')
    @livewire('customer.view', [
        'customer_id' => $id,
    ])
@endsection
