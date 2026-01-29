@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <div class="glass rounded-xl p-12 max-w-2xl mx-auto">
        <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-500/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-white mb-4">Order Placed Successfully!</h1>
        <p class="text-gray-300 mb-8 text-lg">Thank you for your purchase. Your pet is going to love it!</p>
        <a href="{{ route('home') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg shadow-amber-500/20">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
