@extends('layouts.app')

@section('content')
<!-- Back Button -->
<div class="mb-6 max-w-6xl mx-auto mt-8 px-4">
  <a 
    href="{{ route('products.index') }}" 
    class="inline-flex items-center px-4 py-2 border border-black rounded-md bg-white text-black hover:bg-black hover:border-black hover:text-white transition duration-200"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back
  </a>
</div>

<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow mt-8 mb-12">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

    <div>
      <img src="{{ asset('assets/images/'.strtolower($product->category).'/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow" />
    </div>

    <div>
      <h2 class="text-3xl font-bold">{{ $product->name }}</h2>

      <div class="flex items-center mt-2">
        <span class="text-yellow-500 text-xl">★★★★★</span>
        <span class="text-gray-600 ml-2">(12 reviews)</span>
      </div>

      <p class="text-2xl mt-4 font-semibold text-green-600">${{ number_format($product->price, 2) }}</p>
      <p class="mt-4 text-gray-700">{{ $product->description }}</p>

      <form method="post" action="{{ route('cart.add') }}" class="mt-6 flex items-center">
        @csrf
        <label for="quantity" class="mr-2 font-medium">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" class="border rounded w-20 p-2 mr-4" />
        <input type="hidden" name="product_id" value="{{ $product->id }}" />
        <button
            type="submit"
            class="bg-green-500 text-white text-sm px-4 py-1.5 rounded hover:bg-green-600 transition"
        >
            Add to Cart
        </button>
        </form>


      <h3 class="mt-6 text-lg font-bold">Product Features</h3>
      <ul class="list-disc list-inside mt-2 text-gray-700">
          <li>High quality ingredients</li>
          <li>Vet recommended</li>
          <li>Satisfaction guaranteed</li>
      </ul>
    </div>
  </div>

  <h3 class="mt-12 text-xl font-bold">Customer Reviews</h3>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
      <div class="border border-gray-200 rounded p-4 shadow-sm">
        <strong>Sarah M.</strong>
        <span class="text-gray-500 text-sm"> - 2 days ago</span>
        <p class="mt-1 text-gray-700">Excellent quality! My dog loves it.</p>
      </div>
      <div class="border border-gray-200 rounded p-4 shadow-sm">
        <strong>Mike L.</strong>
        <span class="text-gray-500 text-sm"> - 1 week ago</span>
        <p class="mt-1 text-gray-700">Good value for money; fast delivery.</p>
      </div>
  </div>

  <h3 class="mt-12 text-xl font-bold text-center">Related Products</h3>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-4">
    @foreach ($relatedProducts as $related)
    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
        <img 
            src="{{ asset('assets/images/'.strtolower($related->category).'/'.$related->image) }}" 
            alt="{{ $related->name }}" 
            class="w-full h-32 object-contain rounded mb-2" 
        />
        <h4 class="font-semibold">{{ $related->name }}</h4>
        <p class="text-gray-600">${{ number_format($related->price, 2) }}</p>
        <a href="{{ route('products.show', $related->id) }}" class="text-blue-600 hover:underline text-sm">View</a>
    </div>
    @endforeach

</div>
@endsection
