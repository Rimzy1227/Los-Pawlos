@extends('layouts.app')

@section('content')
<!-- Back Button -->
<div class="mb-6 max-w-6xl mx-auto mt-4 px-4">
  <a 
    href="{{ route('home') }}" 
    class="inline-flex items-center px-4 py-2 border border-black rounded-md bg-white text-black hover:bg-black hover:border-black hover:text-white transition duration-200"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </a>
</div>

<h1 class="text-4xl font-extrabold text-center text-gray-800 mb-8">Our Products</h1>

<livewire:product-browser />

@endsection
