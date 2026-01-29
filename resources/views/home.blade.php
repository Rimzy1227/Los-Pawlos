@extends('layouts.app')

@section('content')

<!-- hero -->
<section class="relative bg-cover bg-center h-[500px] sm:h-[600px]" style="background-image:url('{{ asset('assets/images/hero1.jpg') }}')">
  <div class="absolute inset-0 bg-black/50"></div>

  <div class="relative z-10 flex flex-col justify-center items-center h-full text-center text-white px-4">
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 leading-tight">
      Premium Pet Supplies for Your Furry Family
    </h1>
    <p class="mb-6 max-w-xl text-base sm:text-lg">
      Discover high-quality food, toys, and accessories that keep your cats and dogs happy, healthy, and entertained.
    </p>

    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
      <a href="{{ route('products.index') }}" class="btn-brand w-full sm:w-auto text-center">Shop Now</a>
      <a href="{{ route('products.index', ['category' => 'Food']) }}" class="btn-brand w-full sm:w-auto text-center">Browse Food & Treats</a>
    </div>

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-2 text-sm">
      <span class="bg-white/20 px-3 py-1 rounded">Free shipping over $50</span>
      <span class="bg-white/20 px-3 py-1 rounded">Vet approved products</span>
    </div>
  </div>
</section>


<!-- features -->
<section class="py-12 max-w-6xl mx-auto text-center grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
  <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition"><h3 class="font-semibold text-lg">Premium Quality</h3><p>Only the finest products for your pets</p></div>
  <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition"><h3 class="font-semibold text-lg">Free Shipping</h3><p>On orders over $50</p></div>
  <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition"><h3 class="font-semibold text-lg">Safety First</h3><p>Vet-approved & tested</p></div>
  <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition"><h3 class="font-semibold text-lg">5-Star Service</h3><p>Exceptional support always</p></div>
</section>

<!-- shop by category -->
<section class="py-16 bg-gray-300">
  <div class="max-w-6xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">Shop by Category</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8">
      
      <a href="{{ route('products.index', ['category' => 'Food']) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 p-4 flex flex-col items-center text-center">
        <img src="{{ asset('assets/images/food/Large-Breed-Dog-Food-10kg.jpg') }}" alt="Food" class="h-32 w-full object-contain rounded-md mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Food</h3>
      </a>

      <a href="{{ route('products.index', ['category' => 'Toys']) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 p-4 flex flex-col items-center text-center">
        <img src="{{ asset('assets/images/toys/catnip-mouse-pack.jpg') }}" alt="Toys" class="h-32 w-full object-contain rounded-md mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Toys</h3>
      </a>

      <a href="{{ route('products.index', ['category' => 'Grooming']) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 p-4 flex flex-col items-center text-center">
        <img src="{{ asset('assets/images/grooming/pet-nail-clippers.jpg') }}" alt="Grooming" class="h-32 w-full object-contain rounded-md mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Grooming</h3>
      </a>

      <a href="{{ route('products.index', ['category' => 'Accessories']) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 p-4 flex flex-col items-center text-center">
        <img src="{{ asset('assets/images/accessories/hamster-cage-tunnel.jpg') }}" alt="Accessories" class="h-32 w-full object-contain rounded-md mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Accessories</h3>
      </a>

    </div>
  </div>
</section>



<!-- home product -->
<section class="py-6 bg-gray-200">
  <div class="max-w-6xl mx-auto px-4">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-center">Featured Products</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

      <!-- Hardcoded featured products in legacy were hardcoded, but better to skip or use DB if possible. 
           The legacy code had hardcoded HTML for 3 products (ID 1, 2, 3). 
           I will try to loop provided featuredProducts from controller if available, or fallback to the hardcoded like legacy if simpler. 
           The new controller implementation passes $featuredProducts. -->
      
      @forelse($featuredProducts as $p)
       <div class="card bg-white p-4 rounded shadow-sm">
        <img src="{{ asset('assets/images/'.strtolower($p->category).'/'.$p->image) }}" class="rounded mb-3 h-36 w-full object-contain">
        <h3 class="font-semibold text-sm mb-1">{{ $p->name }}</h3>
        <p class="text-xs text-gray-600">{{ $p->description }}</p>
        <div class="flex justify-between items-center mt-2">
          <span class="font-bold text-sm">${{ number_format($p->price, 2) }}</span>
          <a href="{{ route('cart.add') }}" 
             onclick="event.preventDefault(); document.getElementById('add-form-{{$p->id}}').submit();" 
             class="btn-brand text-xs px-3 py-1 cursor-pointer">View (Add)</a>
             
           <form id="add-form-{{$p->id}}" action="{{ route('cart.add') }}" method="POST" class="hidden">
               @csrf
               <input type="hidden" name="product_id" value="{{ $p->id }}">
           </form>
        </div>
      </div>
      @empty
         <!-- Fallback to hardcoded if DB empty -->
         <p>No featured products.</p>
      @endforelse

    </div>
  </div>
</section>

<!-- reviews -->
<section class="py-12 max-w-6xl mx-auto text-center">
  <h2 class="text-2xl font-bold mb-6">What Pet Parents Say</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="card"><p>"My cats absolutely love everything I’ve ordered!"</p><p class="mt-2 font-semibold">- Sarah M.</p></div>
    <div class="card"><p>"Best pet store online. My dog’s favorite toys all come from here."</p><p class="mt-2 font-semibold">- Mike D.</p></div>
    <div class="card"><p>"The automatic litter box is a game-changer!"</p><p class="mt-2 font-semibold">- Emily R.</p></div>
  </div>
</section>

<!-- banner -->
<section class="bg-gradient-to-r from-indigo-500 to-orange-400 py-12 text-center text-white">
  <h2 class="text-3xl font-bold mb-4">Ready to Spoil Your Pets?</h2>
  <p class="mb-6">Join thousands of happy pet parents who trust Los Pawlos Hermanos.</p>
  <a href="{{ route('products.index') }}" class="btn-brand">Start Shopping</a>
  <a href="{{ route('register') }}" class="btn-brand ml-3">Create Account</a>
</section>

<section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4 max-w-6xl mx-auto">
  @foreach($featuredProducts->take(6) as $p)
    <div class="bg-white p-3 rounded-md shadow hover:shadow-md transition">
      <h3 class="font-semibold">{{ $p->name }}</h3>
      <p class="text-sm text-gray-600">{{ $p->category }}</p>
      <p class="mt-2 font-bold">${{ number_format($p->price, 2) }}</p>
      <div class="mt-4 flex justify-between">
        <a class="text-blue-600" href="{{ route('products.show', $p->id) }}">View</a>
        <form method="post" action="{{ route('cart.add') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $p->id }}">
          <button class="bg-green-500 text-white px-3 py-1 rounded">Add to cart</button>
        </form>
      </div>
    </div>
  @endforeach
</section>

@endsection
